
<span style="font-size:14px;"><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html
            xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type"
                                                             content="text/html; charset=utf-8"/><style type="text/css"><!--
            body, table {
                font-size: 13px;
            }

            table {
                table-layout: fixed;
                empty-cells: show;
                border-collapse: collapse;
                margin: 0 auto;
                border: 1px solid #cad9ea;
            }

            th {
                height: 22px;
                font-size: 13px;
                font-weight: bold;
                background-color: #CCCCCC;
                text-align: center;
            }

            td {
                height: 20px;
            }

            .tableTitle {
                font-size: 14px;
                font-weight: bold;
            } </style><title>熙香数据库结构</title></head> <body><div
            style="margin:0 auto;width:880px; border:1px #006600 solid; font-size:12px; line-height:20px;">  <div
                style="width:100%;height:30px; font-size:16px; font-weight:bold; text-align:center;">  熙香数据库结构<br/>  <font
                    style="font-size:14px; font-weight:normal;">
        </div> <?php $dbconn = mysqli_connect("47.98.186.51", "xxfood", "xxfood1234&");
        $sqlname = "information_schema";
        mysqli_select_db($dbconn,$sqlname);
        session_start();
        $sql = "SELECT * FROM tables where table_schema='xxfood' order by TABLE_NAME";
        $result = mysqli_query($dbconn,$sql);

        while ($row = mysqli_fetch_array($result)) {    //print_r($row);  ?>
        <div style="margin:0 auto; width:100%; padding-top:10px;">    <b
                    class="tableTitle">表名： <?php echo $row["TABLE_NAME"] ?> </b> <br/> <?php echo $row["TABLE_COMMENT"] ?>  </div>
            <table width="100%" border="1">    <thead>
                <th width="160">字段名
                </td>
                <th width="120">字段类型
                </td>
                <th width="80">允许为空
                </td>
                <th width="70">默认值
                </td>
                <th width="400">备注
                </td>    </thead> <?php $sql2 = "SELECT * FROM columns where table_name='" . $row["TABLE_NAME"] . "'";
                $result2 = mysqli_query($dbconn,$sql2);

                $num = 0;
                while ($row2 = mysqli_fetch_array($result2)) {
                $num = $num + 1;      //print_r($row);    ?>
                <tr><td width="20"><?php echo $row2["COLUMN_NAME"] ?>
                        </td>
                        <td width="20"><?php echo $row2["COLUMN_TYPE"] ?></td>
                        <td align="center" width="20"><?php echo $row2["IS_NULLABLE"] ?>
                        </td>
                        <td align="center" width="20"><?php echo $row2["COLUMN_DEFAULT"] ?></td>
                        <td width="50"><?php echo $row2["COLUMN_COMMENT"] ?></td>    </tr>    <?php } ?>  </table>  <?php }
        mysqli_close($dbconn); ?>
    </div></body></html></span>
<?php exit; ?>
@extends('admin.base')

@section('content')
    <div class="layui-row layui-col-space15">

        <div class="layui-col-md8">

            <div class="layui-card">

                <div class="layui-card-header">

                    最近更新

                    <a lay-href="http://www.layui.com/doc/base/changelog.html" class="layui-a-tips">全部更新</a>

                </div>

                <div class="layui-card-body">

                    <div class="layui-row layui-col-space10">

                        <div class="layui-col-xs12 layui-col-sm4">

                            <div class="layuiadmin-card-text">

                                <div class="layui-text-top"><i class="layui-icon layui-icon-water"></i><a lay-href="http://www.layui.com/doc/modules/flow.html">flow</a></div>

                                <p class="layui-text-center">修复开启 isLazyimg:true 后, 图片懒加载但是图片不存在的报错问题</p>

                                <p class="layui-text-bottom"><a lay-href="http://www.layui.com/doc/modules/flow.html">流加载</a><span>7 天前</span></p>

                            </div>

                        </div>

                        <div class="layui-col-xs12 layui-col-sm4">

                            <div class="layuiadmin-card-text">

                                <div class="layui-text-top"><i class="layui-icon layui-icon-upload-circle"></i><a lay-href="http://www.layui.com/doc/modules/upload.html">upload</a></div>

                                <p class="layui-text-center">修复开启 size 参数后，文件超出规定大小时，提示信息有误的问题</p>

                                <p class="layui-text-bottom"><a lay-href="http://www.layui.com/doc/modules/upload.html">文件上传</a><span>7 天前</span></p>

                            </div>

                        </div>

                        <div class="layui-col-xs12 layui-col-sm4">

                            <div class="layuiadmin-card-text">

                                <div class="layui-text-top"><i class="layui-icon layui-icon-form"></i><a lay-href="http://www.layui.com/doc/modules/form.html#val">form</a></div>

                                <p class="layui-text-center">增加 form.val(filter, fields)方法，用于给指定表单集合的元素初始赋值</p>

                                <p class="layui-text-bottom"><a lay-href="http://www.layui.com/doc/modules/form.html">表单</a><span>7 天前</span></p>

                            </div>

                        </div>

                        <div class="layui-col-xs12 layui-col-sm4">

                            <div class="layuiadmin-card-text">

                                <div class="layui-text-top"><i class="layui-icon layui-icon-form"></i><a lay-href="http://www.layui.com/doc/modules/form.html">form</a></div>

                                <p class="layui-text-center">对 select 组件新增上下键（↑ ↓）回车键（Enter）选择功能</p>

                                <p class="layui-text-bottom"><a lay-href="http://www.layui.com/doc/modules/form.html">表单</a><span>7 天前</span></p>

                            </div>

                        </div>

                        <div class="layui-col-xs12 layui-col-sm4">

                            <div class="layuiadmin-card-text">

                                <div class="layui-text-top"><i class="layui-icon layui-icon-form"></i><a lay-href="http://www.layui.com/doc/modules/form.html">form</a></div>

                                <p class="layui-text-center">优化 switch 开关组件，让其能根据文本自由伸缩宽</p>

                                <p class="layui-text-bottom"><a lay-href="http://www.layui.com/doc/modules/form.html">表单</a><span>7 天前</span></p>

                            </div>

                        </div>

                        <div class="layui-col-xs12 layui-col-sm4">

                            <div class="layuiadmin-card-text">

                                <div class="layui-text-top"><i class="layui-icon layui-icon-form"></i><a lay-href="http://www.layui.com/doc/modules/form.html">form</a></div>

                                <p class="layui-text-center">修复 checkbox 复选框组件在高分辨屏下出现的样式不雅问题</p>

                                <p class="layui-text-bottom"><a lay-href="http://www.layui.com/doc/modules/form.html">表单</a><span>7 天前</span></p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="layui-card">

                <div class="layui-card-header">动态</div>

                <div class="layui-card-body">

                    <dl class="layuiadmin-card-status">

                        <dd>

                            <div class="layui-status-img"><a href="javascript:;"><img src="../../layuiadmin/style/res/logo.png"></a></div>

                            <div>

                                <p>胡歌 在 <a lay-href="http://fly.layui.com/vipclub/list/layuiadmin/">layuiadmin专区</a> 回答问题</p>

                                <span>几秒前</span>

                            </div>

                        </dd>

                        <dd>

                            <div class="layui-status-img"><a href="javascript:;"><img src="../../layuiadmin/style/res/logo.png"></a></div>

                            <div>

                                <p>彭于晏 在 <a lay-href="http://fly.layui.com/vipclub/list/layuiadmin/">layuiadmin专区</a> 进行了 <a lay-href="http://fly.layui.com/vipclub/list/layuiadmin/column/quiz/">提问</a></p>

                                <span>2天前</span>

                            </div>

                        </dd>

                        <dd>

                            <div class="layui-status-img"><a href="javascript:;"><img src="../../layuiadmin/style/res/logo.png"></a></div>

                            <div>

                                <p>贤心 将 <a lay-href="http://www.layui.com/">layui</a> 更新至 2.3.0 版本</p>

                                <span>7天前</span>

                            </div>

                        </dd>

                        <dd>

                            <div class="layui-status-img"><a href="javascript:;"><img src="../../layuiadmin/style/res/logo.png"></a></div>

                            <div>

                                <p>吴尊 在 <a lay-href="http://fly.layui.com/">Fly社区</a> 发布了 <a lay-href="http://fly.layui.com/column/suggest/">建议</a></p>

                                <span>7天前</span>

                            </div>

                        </dd>

                        <dd>

                            <div class="layui-status-img"><a href="javascript:;"><img src="../../layuiadmin/style/res/logo.png"></a></div>

                            <div>

                                <p>许上进 在 <a lay-href="http://fly.layui.com/">Fly社区</a> 发布了 <a lay-href="http://fly.layui.com/column/suggest/">建议</a></p>

                                <span>8天前</span>

                            </div>

                        </dd>

                        <dd>

                            <div class="layui-status-img"><a href="javascript:;"><img src="../../layuiadmin/style/res/logo.png"></a></div>

                            <div>

                                <p>小蚊子 在 <a lay-href="http://fly.layui.com/vipclub/list/layuiadmin/">layuiadmin专区</a> 进行了 <a lay-href="http://fly.layui.com/vipclub/list/layuiadmin/column/quiz/">提问</a></p>

                                <span>8天前</span>

                            </div>

                        </dd>

                    </dl>

                </div>

            </div>

        </div>

        <div class="layui-col-md4">

            <div class="layui-card">

                <div class="layui-card-header">便捷导航</div>

                <div class="layui-card-body">

                    <div class="layuiadmin-card-link">

                        <a href="javascript:;">操作一</a>

                        <a href="javascript:;">操作二</a>

                        <a href="javascript:;">操作三</a>

                        <a href="javascript:;">操作四</a>

                        <a href="javascript:;">操作五</a>

                        <a href="javascript:;">操作六</a>

                        <button class="layui-btn layui-btn-primary layui-btn-xs">

                            <i class="layui-icon layui-icon-add-1" style="position: relative; top: -1px;"></i>添加

                        </button>

                    </div>

                </div>

            </div>

            <div class="layui-card">

                <div class="layui-card-header">八卦新闻</div>

                <div class="layui-card-body">



                    <div class="layui-carousel layadmin-carousel layadmin-dataview" data-anim="fade" lay-filter="LAY-index-pageone">

                        <div carousel-item id="LAY-index-pageone">

                            <div><i class="layui-icon layui-icon-loading1 layadmin-loading"></i></div>

                        </div>

                    </div>



                </div>

            </div>

            <div class="layui-card">

                <div class="layui-card-header">重点组件</div>

                <div class="layui-card-body">

                    <ul class="layui-row layuiadmin-card-team">

                        <li class="layui-col-xs6">

                            <a lay-href="http://www.layui.com/doc/modules/table.html">

                                <span class="layui-team-img"><img src="../../layuiadmin/style/res/logo.png"></span>

                                <span>数据表格</span>

                            </a>

                        </li>

                        <li class="layui-col-xs6">

                            <a lay-href="http://www.layui.com/doc/modules/layim.html">

                                <span class="layui-team-img"><img src="../../layuiadmin/style/res/logo.png"></span>

                                <span>即时通讯</span>

                            </a>

                        </li>

                        <li class="layui-col-xs6">

                            <a lay-href="http://www.layui.com/doc/modules/form.html">

                                <span class="layui-team-img"><img src="../../layuiadmin/style/res/logo.png"></span>

                                <span>表单</span>

                            </a>

                        </li>

                        <li class="layui-col-xs6">

                            <a lay-href="http://www.layui.com/doc/modules/layer.html">

                                <span class="layui-team-img"><img src="../../layuiadmin/style/res/logo.png"></span>

                                <span>弹出层</span>

                            </a>

                        </li>

                        <li class="layui-col-xs6">

                            <a lay-href="http://www.layui.com/doc/modules/upload.html">

                                <span class="layui-team-img"><img src="../../layuiadmin/style/res/logo.png"></span>

                                <span>文件上传</span>

                            </a>

                        </li>

                        <li class="layui-col-xs6">

                            <a lay-href="http://www.layui.com/doc/modules/rate.html">

                                <span class="layui-team-img"><img src="../../layuiadmin/style/res/logo.png"></span>

                                <span>评分</span>

                            </a>

                        </li>

                    </ul>

                </div>

            </div>

        </div>

    </div>
@endsection

@section('script')
    <script>
        layui.use(['index', 'sample']);
    </script>
@endsection