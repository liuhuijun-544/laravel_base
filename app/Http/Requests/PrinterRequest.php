<?php

namespace App\Http\Requests;

use App\Models\Printer;
use Illuminate\Foundation\Http\FormRequest;

class PrinterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $return = [
            'title' => 'required|string',
//            'type' => 'required|in:' . implode(',', array_keys(Printer::$type)),
            'printer_sn' => 'required|string',
//            'printer_key' => 'required|string',
//            'printer_ip' => 'required|string',
//            'printer_port' => 'required|numeric',
//            'host_name' => 'required|string',
            'store_id' => 'required|numeric',
            'print_type' => 'required|in:' . implode(',', array_keys(Printer::$print_type)),
            'paper' => 'required|in:' . implode(',', Printer::$paper),
        ];

        // 已舍弃的字段，给默认值
        $this['type'] = 1;
        $this['printer_port'] = 1111;
        $this['printer_key'] = $this['printer_ip'] = $this['host_name'] = '';

        if ($this->get('print_type') == 1) {   // 标签打印
            unset($this['package'], $this['canteen'], $this['personal'], $this['is_return']);
            $this['print_way'] = 1;
            $return['workspace_id'] = 'required|numeric';
            $return['total'] = 'required|numeric';
        } else if ($this->get('print_type') == 2) {   // 收银台打印
            $this['workspace_id'] = $this['total'] = 0;
            $this['print_way'] = 1;
            $return['package'] = 'required|numeric';
            $return['canteen'] = 'required|numeric';
            $return['personal'] = 'required|numeric';
        } else {    // 后厨（工作间）打印
            unset($this['package'], $this['canteen'], $this['personal']);
            $return['print_way'] = 'required|in:' . implode(',', array_keys(Printer::$print_way));
            $return['workspace_id'] = 'required|numeric';
            $return['total'] = 'required|numeric';
        }
        return $return;
    }
}
