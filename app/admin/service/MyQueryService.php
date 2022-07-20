<?php
/*
 * @Description  : 管理
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-05-06
 * @LastEditTime : 2020-12-25
 */

namespace app\admin\service;

use think\facade\Db;

class MyQueryService
{
    private string $table;
    private string $alias;
    private array $where = [];
    private array $serverId = [];
    private array $leftJoin = [];
    private int $limit = 10;
    private int $page = 1;
    private string $field = '*';
    private string $subqueryField;
    private array $subqueryWhere = [];
    private bool $all = false;
    private string $order = '';
    private array $fieldSubquery = [];
    private string $group = '';


    /**
     * 全服数据分页查询
     */
    public function paginate(): array
    {
        $unionAll = [];
        $sql = '';
        // 查询服务器
        $serverList = Db::connect('gmt')->table('server')->where('server_id', 'in', $this->serverId)->field('server_id,extend2')->select()->toArray();
        if (!$serverList) {
            exception('游戏服务器不存在');
        }
        foreach ($serverList as $row) {
            $id = $row['server_id'];
            [$host, $db] = explode(':', $row['extend2']);
            /** FEDERATED引擎连接数太多，效率和连都容易打满，暂时只考虑同主机情况 */
            $fields = $this->field . ",$id as serverIds";
            if (env('APP.FEDERATED', false)) {
                // 子查询
                foreach ($this->fieldSubquery as $subqueryInfo) {
                    $fields .= ',' . sprintf($subqueryInfo['sql'], $subqueryInfo['table'] . $id, $subqueryInfo['fieldName']);
                }
                $sqls = Db::table($this->table . $id)
                    ->where($this->where)
                    ->alias($this->alias)
                    ->field($fields);
                // left join
                foreach ($this->leftJoin as $join) {
                    $joinTable = [];
                    if (is_array($join[0])) {
                        foreach ($join[0] as $k => $v) {
                            $joinTable[$k . $id] = $v;
                        }
                    } else {
                        $joinTable = $join;
                    }
                    $sqls = $sqls->leftJoin($joinTable, $join[1]);
                }
            } else {
                // 子查询
                foreach ($this->fieldSubquery as $subqueryInfo) {
                    $fields .= ',' . sprintf($subqueryInfo['sql'], $db . '.' . $subqueryInfo['table'], $subqueryInfo['fieldName']);
                }
                $sqls = Db::table($db . '.' . $this->table)
                    ->where($this->where)
                    ->alias($this->alias)
                    ->field($fields);
                // left join
                foreach ($this->leftJoin as $join) {
                    $joinTable = [];
                    if (is_array($join[0])) {
                        foreach ($join[0] as $k => $v) {
                            $joinTable[$db . '.' . $k] = $v;
                        }
                    } else {
                        $joinTable = $join;
                    }
                    $sqls = $sqls->leftJoin($joinTable, $join[1]);
                }
                // group
                if($this->group){
                    $sqls = $sqls->group($this->group);
                }
            }
            // unionAll or sql
            if ($sql) {
                $unionAll[] = $sqls->fetchSql(true)->select();
            } else {
                $sql = $sqls;
            }
        }
        if ($unionAll) {
            $sql = $sql->unionAll($unionAll, true)->buildSql();
            $sql = Db::table($sql . 'as f');
        }
        // order
        if($this->order){
            $sql = $sql->order($this->order);
        }
        $serverData = [];
        if ($this->all) {
            $serverData = $sql->select()->toArray();
        } else {
            $serverData = $sql->paginate($this->limit)->toArray();
        }
        return $serverData;
    }

    /**
     * 日志统计查询
     */
    public function logSurvey($startTime, $endTime): array
    {
        $serverId = $this->serverId;
        $where    = $this->where;
        $table    = $this->table;
        $unionAll = [];
        // 查询服务器
        $serverList = Db::connect('gmt')->table('server')->where('server_id', 'in', $serverId)->field('server_id,extend2')->select()->toArray();
        if (!$serverList) {
            exception('游戏服务器不存在');
        }
        // 开始时间
        $startTime  = $startTime ?: date('Y-m-d') . ' 00:00:00';
        $startTime  = explode(' ', $startTime)[0];
        $endTime    = $endTime ?: date('Y-m-d', strtotime('+1 day')) . ' 00:00:00';
        $endTime    = explode(' ', $endTime)[0];
        $diff       = date_diff(date_create($startTime), date_create($endTime));
        $tableTime  = strtotime($startTime);
        $tables     = [];
        $allData    = [];
        for ($i = 0; $i <= $diff->days; $i++) {
            $sql = null;
            $unionAll = [];
            foreach ($serverList as $row) {
                $id = $row['server_id'];
                [$host, $db] = explode(':', $row['extend2']);
                /** FEDERATED引擎连接数太多容易打满，效率不好，暂时只考虑同主机情况 */
                if (env('APP.FEDERATED', false)) {
                    continue;
                }
                if (!isset($tables[$id])) {
                    $ts = Db::table('information_schema.tables')->field('table_name')->where('table_schema', $db)->whereLike('table_name', '%' . $table . '%')->column('table_name');
                    $tables[$id] = array_flip($ts);
                }
                $logtable = $table . date('Ymd', $tableTime);
                // 有无表，有就关联，无就不管
                if (!isset($tables[$id][$logtable])) continue;
                // 生成sql
                $sqls = Db::table("$db.$logtable")
                    ->alias($this->alias)
                    ->where($this->subqueryWhere)
                    ->field($this->subqueryField);

                // left join
                foreach ($this->leftJoin as $join) {
                    $joinTable = [];
                    if (is_array($join[0])) {
                        foreach ($join[0] as $k => $v) {
                            $joinTable[$db . '.' . $k] = $v;
                        }
                    } else {
                        $joinTable = $join;
                    }
                    $sqls = $sqls->leftJoin($joinTable, $join[1]);
                }

                // group
                if ($this->group) {
                    $sqls = Db::table($sqls->buildSql() . ' sub')->group('sub.' . $this->group)->field($this->field);
                }

                // unionAll or sql
                if (!$sql) {
                    $sql = $sqls;
                } else {
                    $unionAll[] = $sqls->fetchSql(true)->select();
                }
            }
            if ($unionAll) {
                $sql = $sql->unionAll($unionAll, true)->buildSql();
                $sql = Db::table($sql . ' as f');
            }
            if ($sql) {
                $allData = array_merge($allData, $sql->select()->toArray());
            }
            $tableTime += 86400;
        }
        return $allData;
    }

    /**
     * 日志数据查询
     */
    public function logSurveyPaginate($startTime, $endTime): array
    {
        $serverId = $this->serverId;
        $limit    = $this->limit;     // 每页数量
        $ylimit   = $this->limit;
        $page     = $this->page;      // 当前页
        $where    = $this->where;
        $table    = $this->table;
        $unionAll = [];

        // 查询服务器
        $serverList = Db::connect('gmt')->table('server')->where('server_id', 'in', $serverId)->field('server_id,extend2')->select()->toArray();
        if (!$serverList) {
            exception('游戏服务器不存在');
        }

        // 开始时间
        $startTime  = $startTime ?: date('Y-m-d') . ' 00:00:00';
        $startTime  = explode(' ', $startTime)[0];
        $endTime    = $endTime ?: date('Y-m-d', strtotime('+1 day')) . ' 00:00:00';
        $endTime    = explode(' ', $endTime)[0];
        $diff       = date_diff(date_create($startTime), date_create($endTime));
        $tableTime  = strtotime($startTime);
        $countTotal = [];
        $tables     = [];
        $allData    = [];
        // 判断是否查询全数据
        $field = "1 as total";
        for ($i = 0; $i <= $diff->days; $i++) {
            $sql = null;
            $unionAll = [];
            foreach ($serverList as $row) {
                $id = $row['server_id'];
                [$host, $db] = explode(':', $row['extend2']);
                $allfield = $this->all ? $this->field . ",$id as serverIds" : $field;
                /** FEDERATED引擎连接数太多容易打满，效率不好，暂时只考虑同主机情况 */
                if (env('APP.FEDERATED', false)) {
                    continue;
                }
                if (!isset($tables[$id])) {
                    $ts = Db::table('information_schema.tables')->field('table_name')->where('table_schema', $db)->whereLike('table_name', '%' . $table . '%')->column('table_name');
                    $tables[$id] = array_flip($ts);
                }
                $logtable = $table . date('Ymd', $tableTime);
                // 有无表，有就关联，无就不管
                if (!isset($tables[$id][$logtable])) continue;
                // 生成sql
                if ($this->subqueryField) {
                    $sqls = Db::table("$db.$logtable")
                        ->alias($this->alias)
                        ->where($this->subqueryWhere)
                        ->field($this->subqueryField);
                    $sqls = Db::table($sqls->buildSql() . ' sub')
                        ->field($allfield);
                } else {
                    $sqls = Db::table("$db.$logtable")
                        ->alias($this->alias)
                        ->field($allfield);
                }
                // group
                if ($this->group) {
                    $sqls = $sqls->group($this->group);
                }
                // where
                if ($where) {
                    $sqls = $sqls->where($where);
                }

                // left join
                foreach ($this->leftJoin as $join) {
                    $joinTable = [];
                    if (is_array($join[0])) {
                        foreach ($join[0] as $k => $v) {
                            $joinTable[$db . '.' . $k] = $v;
                        }
                    } else {
                        $joinTable = $join;
                    }
                    $sqls = $sqls->leftJoin($joinTable, $join[1]);
                }
                // unionAll or sql
                if (!$sql) {
                    $sql = $sqls;
                } else {
                    $unionAll[] = $sqls->fetchSql(true)->select();
                }
            }
            if ($unionAll) {
                $sql = $sql->unionAll($unionAll, true)->buildSql();
                $sql = Db::table($sql . ' as f');
            }
            if ($sql && $this->all) {
                $allData = array_merge($allData, $sql->select()->toArray());
            } else if ($sql && $unionAll) {
                // dump($unionAll);
                // dump($sql->select());
                $countTotal[date('Ymd', $tableTime)] = (int)$sql->sum('total');
            } else if ($sql) {
                $countTotal[date('Ymd', $tableTime)] = (int)$sql->count();
            }
            $tableTime += 86400;
        }
        if ($this->all) {
            return $allData;
        }
        krsort($countTotal);
        //计算分页
        $total        = (int)array_sum($countTotal);                   // 总条数
        $last_page    = (int)ceil($total / $limit);                    // 总页数
        $current_page = (int)min($last_page, $page);                   // 当前页
        $offset       = $current_page * $limit;                        // 偏移量
        $pos          = $limit;                                        // 偏移值 直接第一页的量
        $serverData   = [];
        $field        = $this->field . ",%d as serverIds";
        $one = false;
        // 循环数量统计数据
        foreach ($countTotal as $table => $tot) {
            if (!$tot) continue;
            $pos += $tot;
            // 第一次偏移量计算出来之后不需要跳过循环
            if ($pos <= $offset && !$one) continue;;
            $sql          = null;
            $unionAll     = [];
            foreach ($serverList as $row) {
                $id = $row['server_id'];
                [$host, $db] = explode(':', $row['extend2']);
                // 有无表，有就关联，无就不管
                if (!isset($tables[$id]['log' . $table])) continue;
                // 生成sql
                if ($this->subqueryField) {
                    $sqls = Db::table("$db.log$table")
                        ->alias($this->alias)
                        ->where($this->subqueryWhere)
                        ->field($this->subqueryField);
                    $sqls = Db::table($sqls->buildSql() . ' sub')
                        ->field(sprintf($field, $id));
                } else {
                    $sqls = Db::table("$db.log$table")
                        ->alias($this->alias)
                        ->field(sprintf($field, $id));
                }
                // group
                if ($this->group) {
                    $sqls = $sqls->group($this->group);
                }
                // where
                if ($where) {
                    $sqls = $sqls->where($where);
                }

                // left join
                foreach ($this->leftJoin as $join) {
                    $joinTable = [];
                    if (is_array($join[0])) {
                        foreach ($join[0] as $k => $v) {
                            $joinTable[$db . '.' . $k] = $v;
                        }
                    } else {
                        $joinTable = $join;
                    }
                    $sqls = $sqls->leftJoin($joinTable, $join[1]);
                }

                if (!$sql) {
                    $sql = $sqls;
                } else {
                    $unionAll[] = $sqls->fetchSql(true)->select();
                }
            }
            if ($unionAll) {
                $sql = $sql->unionAll($unionAll, true)->buildSql();
                $sql = Db::table($sql . ' f');
            }
            if ($sql) {
                // 只要serverData有数据了下次执行分页必定是1
                if (!$serverData) {
                    // 第一次执行计算偏移量
                    $one = true;
                    $newoffset = $tot - ($pos - $offset);
                    $serverData = array_merge($serverData, $sql->limit($newoffset, $limit)->order($this->order)->select()->toArray());
                    // dump('$newoffset:' . $newoffset);
                } else {
                    $serverData = array_merge($serverData, $sql->page(1, $limit)->order($this->order)->select()->toArray());
                }
            }
            // 计算下次limit
            $limit = $ylimit - count($serverData);
            // 判断当前表数据是否充足，不充足连接下一个表
            if ($limit <= 0) break;
        }
        return [
            'total'        => $total,
            'current_page' => $current_page,
            'last_page'    => $last_page,
            'per_page'     => $ylimit,
            'data'         => $serverData
        ];
    }

    /**
     * 日志数据查询
     */
    public function logPaginate($startTime, $endTime): array
    {
        $serverId = $this->serverId;
        $limit    = $this->limit;     // 每页数量
        $ylimit   = $this->limit;
        $page     = $this->page;      // 当前页
        $where    = $this->where;
        $table    = $this->table;
        $unionAll = [];

        // 查询服务器
        $serverList = Db::connect('gmt')->table('server')->where('server_id', 'in', $serverId)->field('server_id,extend2')->select()->toArray();
        if (!$serverList) {
            exception('游戏服务器不存在');
        }

        // 开始时间
        $startTime  = $startTime ?: date('Y-m-d') . ' 00:00:00';
        $startTime  = explode(' ', $startTime)[0];
        $endTime    = $endTime ?: date('Y-m-d', strtotime('+1 day')) . ' 00:00:00';
        $endTime    = explode(' ', $endTime)[0];
        $diff       = date_diff(date_create($startTime), date_create($endTime));
        $tableTime  = strtotime($startTime);
        $countTotal = [];
        $tables     = [];
        $allData    = [];
        // 判断是否查询全数据
        $field = "count(*) as total";
        for ($i = 0; $i <= $diff->days; $i++) {
            $sql = null;
            $unionAll = [];
            foreach ($serverList as $row) {
                $id = $row['server_id'];
                [$host, $db] = explode(':', $row['extend2']);
                $allfield = $this->all ? $this->field . ",$id as serverIds" : $field;
                /** FEDERATED引擎连接数太多容易打满，效率不好，暂时只考虑同主机情况 */
                if (env('APP.FEDERATED', false)) {
                    continue;
                }
                if (!isset($tables[$id])) {
                    $ts = Db::table('information_schema.tables')->field('table_name')->where('table_schema', $db)->whereLike('table_name', '%' . $table . '%')->column('table_name');
                    $tables[$id] = array_flip($ts);
                }
                $logtable = $table . date('Ymd', $tableTime);
                // 有无表，有就关联，无就不管
                if (!isset($tables[$id][$logtable])) continue;
                // 生成sql
                $sqls = Db::table("$db.$logtable")
                    ->alias($this->alias)
                    ->where($where)
                    ->field($allfield);

                // group
                if ($this->group) {
                    $sqls = $sqls->group($this->group);
                }

                // left join
                foreach ($this->leftJoin as $join) {
                    $joinTable = [];
                    if (is_array($join[0])) {
                        foreach ($join[0] as $k => $v) {
                            $joinTable[$db . '.' . $k] = $v;
                        }
                    } else {
                        $joinTable = $join;
                    }
                    $sqls = $sqls->leftJoin($joinTable, $join[1]);
                }
                // unionAll or sql
                if (!$sql) {
                    $sql = $sqls;
                } else {
                    $unionAll[] = $sqls->fetchSql(true)->select();
                }
            }
            if ($unionAll) {
                $sql = $sql->unionAll($unionAll, true)->buildSql();
                $sql = Db::table($sql . ' as f');
            }
            if ($sql && $this->all) {
                $allData = array_merge($allData, $sql->select()->toArray());
            } else if ($sql && $unionAll) {
                $countTotal[date('Ymd', $tableTime)] = (int)$sql->sum('total');
            } else if ($sql) {
                $countTotal[date('Ymd', $tableTime)] = (int)$sql->count();
            }
            $tableTime += 86400;
        }
        if ($this->all) {
            return $allData;
        }
        krsort($countTotal);
        //计算分页
        $total        = (int)array_sum($countTotal);                   // 总条数
        $last_page    = (int)ceil($total / $limit);                    // 总页数
        $current_page = (int)min($last_page, $page);                   // 当前页
        $offset       = $current_page * $limit;                        // 偏移量
        $pos          = $limit;                                        // 偏移值 直接第一页的量
        $serverData   = [];
        $field        = $this->field . ",%d as serverIds";
        $one = false;
        // 循环数量统计数据
        foreach ($countTotal as $table => $tot) {
            if (!$tot) continue;
            $pos += $tot;
            // 第一次偏移量计算出来之后不需要跳过循环
            if ($pos <= $offset && !$one) continue;;
            $sql          = null;
            $unionAll     = [];
            foreach ($serverList as $row) {
                $id = $row['server_id'];
                [$host, $db] = explode(':', $row['extend2']);
                // 有无表，有就关联，无就不管
                if (!isset($tables[$id]['log' . $table])) continue;
                // 生成sql
                $sqls = Db::table("$db.log$table")
                    ->alias($this->alias)
                    ->where($where)
                    ->field(sprintf($field, $id));

                // group
                if ($this->group) {
                    $sqls = $sqls->group($this->group);
                }

                // left join
                foreach ($this->leftJoin as $join) {
                    $joinTable = [];
                    if (is_array($join[0])) {
                        foreach ($join[0] as $k => $v) {
                            $joinTable[$db . '.' . $k] = $v;
                        }
                    } else {
                        $joinTable = $join;
                    }
                    $sqls = $sqls->leftJoin($joinTable, $join[1]);
                }

                if (!$sql) {
                    $sql = $sqls;
                } else {
                    $unionAll[] = $sqls->fetchSql(true)->select();
                }
            }
            if ($unionAll) {
                $sql = $sql->unionAll($unionAll, true)->buildSql();
                $sql = Db::table($sql . ' f');
            }
            if ($sql) {
                // 只要serverData有数据了下次执行分页必定是1
                if (!$serverData) {
                    // 第一次执行计算偏移量
                    $one = true;
                    $newoffset = $tot - ($pos - $offset);
                    $serverData = array_merge($serverData, $sql->limit($newoffset, $limit)->order($this->order)->select()->toArray());
                    // dump('$newoffset:' . $newoffset);
                } else {
                    $serverData = array_merge($serverData, $sql->page(1, $limit)->order($this->order)->select()->toArray());
                }
            }
            // dump('$table:' . $table);
            // dump('$pos:' . $pos);
            // dump('$limit:' . $limit);
            // dump('$ylimit:' . $ylimit);
            // dump('$offset:' . $offset);
            // dump('count($serverData):' . count($serverData));
            // dump('$ylimit - count($serverData):' . $ylimit - count($serverData));
            // dump("==========");
            // 计算下次limit
            $limit = $ylimit - count($serverData);
            // 判断当前表数据是否充足，不充足连接下一个表
            if ($limit <= 0) break;
        }
        // dump(count($serverData));
        // $sourceList = Config::get('source');
        // foreach ($serverData as &$row) {
        //     $row['source'] = $sourceList[$row['source']] ?? $row['source'];
        //     $row['info'] = LogTypeService::format($row['type'], $row['info']);
        // }
        // unset($row);
        return [
            'total'        => $total,
            'current_page' => $current_page,
            'last_page'    => $last_page,
            'per_page'     => $ylimit,
            'data'         => $serverData
        ];
    }

    /**
     * Get the value of table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Set the value of table
     *
     * @return  self
     */
    public function setTable($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Get the value of alias
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set the value of alias
     *
     * @return  self
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get the value of where
     */
    public function getWhere()
    {
        return $this->where;
    }

    /**
     * Set the value of where
     *
     * @return  self
     */
    public function setWhere($where)
    {
        $this->where = $where;

        return $this;
    }

    /**
     * Get the value of serverId
     */
    public function getServerId()
    {
        return $this->serverId;
    }

    /**
     * Set the value of serverId
     *
     * @return  self
     */
    public function setServerId($serverId)
    {
        $this->serverId = $serverId;

        return $this;
    }

    /**
     * Get the value of limit
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Set the value of limit
     *
     * @return  self
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Get the value of page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set the value of page
     *
     * @return  self
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get the value of all
     */
    public function getAll()
    {
        return $this->all;
    }

    /**
     * Set the value of all
     *
     * @return  self
     */
    public function setAll($all)
    {
        $this->all = $all;

        return $this;
    }

    /**
     * Get the value of field
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Set the value of field
     *
     * @return  self
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Get the value of leftJoin
     */
    public function getLeftJoin()
    {
        return $this->leftJoin;
    }

    /**
     * Set the value of leftJoin
     *
     * @return  self
     */
    public function setLeftJoin($leftJoin)
    {
        $this->leftJoin = $leftJoin;

        return $this;
    }

    /**
     * Get the value of order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set the value of order
     *
     * @return  self
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get the value of subquery
     */
    public function getSubquery()
    {
        return $this->subquery;
    }

    /**
     * Set the value of subquery
     *
     * @return  self
     */
    public function setSubquery($subquery)
    {
        $this->subquery = $subquery;

        return $this;
    }

    /**
     * Get the value of fieldSubquery
     */
    public function getFieldSubquery()
    {
        return $this->fieldSubquery;
    }

    /**
     * Set the value of fieldSubquery
     *
     * @return  self
     */
    public function setFieldSubquery($fieldSubquery)
    {
        $this->fieldSubquery = $fieldSubquery;

        return $this;
    }

    /**
     * Get the value of group
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set the value of group
     *
     * @return  self
     */
    public function setGroup($group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get the value of subqueryField
     */
    public function getSubqueryField()
    {
        return $this->subqueryField;
    }

    /**
     * Set the value of subqueryField
     *
     * @return  self
     */
    public function setSubqueryField($subqueryField)
    {
        $this->subqueryField = $subqueryField;

        return $this;
    }

    /**
     * Get the value of subqueryWhere
     */
    public function getSubqueryWhere()
    {
        return $this->subqueryWhere;
    }

    /**
     * Set the value of subqueryWhere
     *
     * @return  self
     */
    public function setSubqueryWhere($subqueryWhere)
    {
        $this->subqueryWhere = $subqueryWhere;

        return $this;
    }
}
