var queryConditions = {
        user_keys: ''
    },  
    hiddenAmount = false, 
    SYSTEM = system = parent.SYSTEM;
var THISPAGE = {
    init: function(data){
        if (SYSTEM.isAdmin === false && !SYSTEM.rights.AMOUNT_COSTAMOUNT) {
            hiddenAmount = true;
        };
        this.mod_PageConfig = Public.mod_PageConfig.init('other-income-list');//页面配置初始化
        this.initDom();
        this.loadGrid();            
        this.addEvent();
    },
    initDom: function(){
        this.$_userName = $('#userName');
        this.$_userName.placeholder();
    },
    loadGrid: function(){
        var gridWH = Public.setGrid(), _self = this;
        var colModel = [
            {name:'operating', label:'操作', width:100, fixed:true, formatter:operFmatter, align:"center"},
            {name:'user_id', label:'用户编号', width:120, align:"center"},
            {name:'user_account', label:'用户帐号', width:150,align:'center'},
            {name:'user_realname', label:'用户姓名', width:150,align:'center'},
            {name:'user_mobile', label:'用户手机号', width:120,align:'center'},
            {name:'user_delete',label:'状态',  width:100,align:'center'},
            {name:'user_money_pending_settlement', label:'待结算余额', width:110, align:"center"},
            {name:'user_money', label:'用户资金', width:110, align:"center"},
            {name:'user_money_frozen', label:'冻结资金', width:110, align:"center"},
            // {name:'user_recharge_card', label:'购物卡余额', width:110, align:"center"},
            // {name:'user_recharge_card_frozen', label:'冻结卡资金', width:110, align:"center"},
            {name:'user_shares', label:'用户股金', width:110, align:"center"},
            {name:'user_pay_shares_date', label:'用户股金达标日期', width:150, align:"center"},
            {name:'user_stocks', label:'用户备货金', width:110, align:"center"},
            {name:'user_login_time', label:'最后登录时间', width:150, align:"center"},
        ];
        this.mod_PageConfig.gridReg('grid', colModel);
        colModel = this.mod_PageConfig.conf.grids['grid'].colModel;
        $("#grid").jqGrid({
            url: SITE_URL +'?ctl=Paycen_PayBase&met=getPayBaseList&typ=json',
            postData: queryConditions,
            datatype: "json",
            autowidth: true,//如果为ture时，则当表格在首次被创建时会根据父元素比例重新调整表格宽度。如果父元素宽度改变，为了使表格宽度能够自动调整则需要实现函数：setGridWidth
            height: gridWH.h,
            altRows: true, //设置隔行显示
            gridview: true,
            multiselect: false,
            multiboxonly: true,
            colModel:colModel,
            cmTemplate: {sortable: false, title: false},
            page: 1, 
            sortname: 'number',    
            sortorder: "desc", 
            pager: "#page",  
            rowNum: 100,
            rowList:[100,200,500], 
            viewrecords: true,
            shrinkToFit: false,
            forceFit: true,
            jsonReader: {
              root: "data.items", 
              records: "data.records",  
              repeatitems : false,
              total : "data.total",
              id: "user_id"
            },
            loadError : function(xhr,st,err) {
                
            },
            ondblClickRow : function(rowid, iRow, iCol, e){
                $('#' + rowid).find('.ui-icon-pencil').trigger('click');
            },
            resizeStop: function(newwidth, index){
                THISPAGE.mod_PageConfig.setGridWidthByIndex(newwidth, index, 'grid');
            }
        }).navGrid('#page',{edit:false,add:false,del:false,search:false,refresh:false}).navButtonAdd('#page',{  
            caption:"",   
            buttonicon:"ui-icon-config",   
            onClickButton: function(){
                THISPAGE.mod_PageConfig.config();
            },   
            position:"last"  
        });
        
    
        function operFmatter (val, opt, row) {
            var stock_html = '';
            //股金达标了，才能填入备货金
            if(row.user_pay_shares_date){
                stock_html = '<span class="ui-icon ui-icon-plus " title="备货金"></span>';
            }
            var html_con = '<div class="operating" data-id="' + row.user_id + '">' +
                '<span class="ui-icon ui-icon-pencil" title="资金"></span>' +
                '<span class="ui-icon ui-icon-circle-plus" title="股金"></span>' + stock_html +
                '</div>';
            return html_con;
        };

        function online_imgFmt(val, opt, row){
                val = '<img src="'+val+'" height=100>';
            return val;
        }

    },
    reloadData: function(data){
        $("#grid").jqGrid('setGridParam',{postData: data}).trigger("reloadGrid");
    },
    addEvent: function(){
        var _self = this;
        //编辑
        $('.grid-wrap').on('click', '.ui-icon-pencil', function(e){
            e.preventDefault();
            var e = $(this).parent().data("id");
            handle.operate("edit", e)
        });
        //删除
        $('.grid-wrap').on('click', '.ui-icon-trash', function(e){
            e.preventDefault();
            if (!Business.verifyRight('QTSR_DELETE')) {
                return ;
            };
        });
        //修改股金
        $('.grid-wrap').on('click', '.ui-icon-circle-plus', function(e){
            e.preventDefault();
            var e = $(this).parent().data("id");
            handle.operate("addShares", e)
        });
        //修改备货金
        $('.grid-wrap').on('click', '.ui-icon-plus', function(e){
            e.preventDefault();
            var e = $(this).parent().data("id");
            handle.operate("addStocks", e)
        });
  
        $('#search').click(function(){
            queryConditions.page = 1;
            queryConditions.user_keys = _self.$_userName.val() === '请输入用户账号/用户姓名/用户手机号' ? '' : _self.$_userName.val();
//            queryConditions.userMobile = _self.$_userMobile.val() === '请输入用户手机号' ? '' : _self.$_userMobile.val();
//            queryConditions.beginDate = _self.$_beginDate.val();
//            queryConditions.endDate = _self.$_endDate.val();
            THISPAGE.reloadData(queryConditions);
        });
        
        $(window).resize(function(){
            Public.resizeGrid();
        });
    }
};
var handle = {
    operate: function (t, e)
    {
        if ("add" == t)
        {
            var i = "新增会员", a = {oper: t, callback: this.callback};
            var url = "url:./index.php?ctl=Paycen_PayBase&met=getEditBase&user_id="+e;
        }
        else if("edit" == t)
        {
            var i = "修改会员资金", a = {oper: t, rowData: $("#grid").jqGrid('getRowData',e), callback: this.callback};
            console.info(a);
            var url = "url:./index.php?ctl=Paycen_PayBase&met=getEditBase&user_id="+e;
        }
        else if("addShares" == t)
        {
            var i = "修改会员股金", a = {oper: t, rowData: $("#grid").jqGrid('getRowData',e), callback: this.callback};
            var url = "url:./index.php?ctl=Paycen_PayBase&met=getEditShares&user_id="+e;
        }
        else if("addStocks" == t)
        {
            var i = "修改会员备货金", a = {oper: t, rowData: $("#grid").jqGrid('getRowData',e), callback: this.callback};
            var url = "url:./index.php?ctl=Paycen_PayBase&met=getEditStocks&user_id="+e;
        }
        $.dialog({
            title: i,
            content: url,
            data: a,
            width: 600,
            height: 400,
            max: !1,
            min: !1,
            cache: !1,
            lock: !0
        })
    }, callback: function (t, e, i)
    {
        window.location.reload(); 
    }
};
$(function(){
    THISPAGE.init();
    
});
