/**
 * Created by Administrator on 2017-10-31.
 */

function initField()
{
    if (rowData.id)
    {
        $('#services_type_id').val(rowData.services_type_id);
        $('#services_type_Name').val(rowData.services_type_Name);
    }
}
function initPopBtns()
{
    var t = "add" == oper ? ["保存", "关闭"] : ["确定", "取消"];
    api.button({
        id: "confirm", name: t[0], focus: !0, callback: function ()
        {
            postData(oper, rowData.id);
            return cancleGridEdit(), $("#manage-form").trigger("validate"), !1;
        }
    }, {id: "cancel", name: t[1]})
}
function postData(t, e)
{
    $('#manage-form').validator({
        ignore: ':hidden',
        theme: 'yellow_bottom',
        timely: 1,
        stopOnError: true,
        fields: {
            'services_type_Name': 'required;'
        },
        valid: function (form)
        {
            var me = this;
            // 提交表单之前，hold住表单，防止重复提交
            me.holdSubmit();

            parent.$.dialog.confirm('修改立马生效,是否继续？', function ()
                {


                    var services_type_id = $.trim($("#services_type_id").val()),
                        services_type_Name = $.trim($("#services_type_Name").val()),
                        n = "add" == t ? "新增服务类型" : "修改服务类型";

                    var params = {services_type_id: services_type_id,services_type_Name: services_type_Name};

                    Public.ajaxPost(SITE_URL + "?ctl=Base_ServiceType&typ=json&met=" + ("add" == t ? "add" : "edit"), params, function (e)
                    {
                        if (200 == e.status)
                        {
                            parent.parent.Public.tips({content: n + "成功！"});
                            callback && "function" == typeof callback && callback(e.data, t, window);
                        }
                        else
                        {
                            parent.parent.Public.tips({type: 1, content: e.msg})
                        }

                        // 提交表单成功后，释放hold，如果不释放hold，就变成了只能提交一次的表单
                        me.holdSubmit(false);
                    })
                },
                function ()
                {
                    me.holdSubmit(false);
                });
        },
    }).on("click", "a.submit-btn", function (e)
    {
        $(e.delegateTarget).trigger("validate");
    });

}
function cancleGridEdit()
{
    null !== curRow && null !== curCol && ($grid.jqGrid("saveCell", curRow, curCol), curRow = null, curCol = null)
}
function resetForm(t)
{
    $("#services_type_Name").val("");
}
var curRow, curCol, curArrears, $grid = $("#grid"), $_form = $("#manage-form"), api = frameElement.api, oper = api.data.oper, rowData = api.data.rowData || {}, callback = api.data.callback;
initPopBtns();
initField();
