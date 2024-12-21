<?php

namespace Modules\Web\Models;

use Core\Model;
use Modules\Web\Models\LogTableSetting;

class LogTrx extends Model {
    protected $table = 'log.transaction';
    protected $primaryKey = 'id_transaction';

    protected $old;
    protected $new;

    public function write($table, $primary_key, $op_type, $old_data, $new_data) {
        $a_table_setting = LogTableSetting::where('table_name', '=', "'".$table."'");
        if(!empty($a_table_setting)) {
            $table_setting = $a_table_setting[0];
            $this->__set('id_table_setting', $table_setting->id_table_setting);
            $this->__set('op', $op_type);
            $this->__set('old_data', $old_data);
            $this->__set('new_data', $new_data);

            for ($i=0; $i < count($primary_key); $i++) { 
                $j = $i;
                $this->__set('pk'.++$j, $primary_key[$i]);
            }

            $this->save();
        }
    }

}
