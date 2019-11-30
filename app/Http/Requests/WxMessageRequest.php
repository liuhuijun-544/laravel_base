<?php

namespace App\Http\Requests;

use App\Models\Printer;
use App\Models\WxMessage;
use Illuminate\Foundation\Http\FormRequest;

class WxMessageRequest extends FormRequest
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
            'type' => 'required|in:' . implode(',', array_keys(WxMessage::$type)),
            'condition' => 'required|in:' . implode(',', WxMessage::$typeCondition[$this->get('type')]),
            'notice_type' => 'required|in:1,2,3',
            'content' => 'required|string',
        ];

        // 通知条件
        if (in_array($this->get('condition'), WxMessage::$hasParam)) {
            $return['param'] = 'required|string';
        }

        // 通知渠道
        $this['is_wx'] = $this->has('is_wx') ? 1 : 0;
        $this['is_note'] = $this->has('is_note') ? 1 : 0;

        // 通知时间
        if ($this->get('notice_type') == 1) {   // 延时
            unset($this['timed_date']);
            $this['day'] && $return['day'] = 'numeric';
            $this['hour'] && $return['hour'] = 'numeric';
            $this['minute'] && $return['minute'] = 'numeric';
        } else if ($this->get('notice_type') == 3) {   // 定时
            unset($this['day'], $this['hour'], $this['minute']);
            $return['timed_date'] = 'required|date_format:"Y-m-d H:i:s"';
        }

        // 重复通知
        $this['repeat'] = $this->has('repeat') ? 1 : 0;
        if ($this['repeat']) {
            $return['repeat_count'] = 'required|numeric';
            $this['repeat_day'] && $return['repeat_day'] = 'numeric';
            $this['repeat_hour'] && $return['repeat_hour'] = 'numeric';
            $this['repeat_minute'] && $return['repeat_minute'] = 'numeric';
        } else {
            unset($this['repeat_count'], $this['repeat_day'], $this['repeat_hour'], $this['repeat_minute']);
        }

        // 是否启用
        $this['status'] = $this->has('status') ? 1 : 0;

        return $return;
    }
}
