<?php 
include __DIR__ . '/../../includes/header.php';
?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-touch-fullscreen" content="yes" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="msapplication-tap-highlight" content="no" />
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,minimum-scale=1" />
    <title>退款列表</title>
    <link rel="stylesheet" type="text/css" href="../../css/base.css">
    <link rel="stylesheet" type="text/css" href="../../css/nctouch_member.css">
</head>

<body>
    <header id="header" class="fixed">
        <div class="header-wrap">
            <div class="header-l">
                <a href="../member/member.html"> <i class="back"></i> </a>
            </div>
            <div class="header-title">
                <h1>退款/退货</h1>
            </div>
        </div>
        <div class="nctouch-nav-layout">
            <div class="nctouch-nav-menu"> <span class="arrow"></span>
                <ul>
                    <li><a href="../../index.html"><i class="home"></i>首页</a></li>
                    <li><a href="../search.html"><i class="search"></i>搜索</a></li>
                    <li><a href="javascript:void(0);"><i class="message"></i>消息<sup></sup></a></li>
                </ul>
            </div>
        </div>
    </header>
    <div class="nctouch-main-layout">
        <div id="fixed_nav" class="nctouch-single-nav fixed">
            <ul id="filtrate_ul" class="w50h">
                <li class="selected"><a href="javascript:void(0);">退款列表</a></li>
                <li><a href="../order/member_return.html">退货列表</a></li>
            </ul>
        </div>
        <div class="nctouch-order-list mt20">
            <ul id="refund-list">
            </ul>
        </div>
    </div>
    <div class="fix-block-r">
        <a href="javascript:void(0);" class="gotop-btn gotop hide" id="goTopBtn"><i></i></a>
    </div>
    <footer id="footer" class="bottom"></footer>
    <script type="text/html" id="refund-list-tmpl">
        <% var refund_list = items; %>
        <% if (refund_list.length > 0){%>
            <% for(var i = 0;i<refund_list.length;i++){
	%>
                <li class=" <%if(i>0){%>mt10<%}%>">
                    <div class="nctouch-order-item">
                        <div class="nctouch-order-item-head">
<!--                            <a href="<%=WapSiteUrl%>/tmpl/order/member_refund_info.html?refund_id=<%=refund_list[i].order_return_id%>" class="store"><i class="icon"></i><%=refund_list[i].seller_user_account%></a>-->

                            <a href="order_detail.html?order_id=<%= refund_list[i].order_number %>"
                               class="store word-ellipsis">订单：<%= refund_list[i].order_number %></a>
                            <span class="state"><%=refund_list[i].return_state_text%></span>
                        </div>

                        <div class="nctouch-order-item-con">

<!--                            <div class="goods-block">-->
<!--                                <a href="<%=WapSiteUrl%>/tmpl/order/member_refund_info.html?refund_id=<%=refund_list[i].order_return_id%>">-->
<!--                                    <dl class="goods-info" style="margin-left: 0;margin-right: 0;">-->
<!--                                        <dt class="goods-name">订单编号</dt>-->
<!--                                        <dd class="goods-type"><%= refund_list[i].order_number %></dd>-->
<!--                                    </dl>-->
<!--                                </a>-->
<!--                            </div>-->

                        </div>

                        <div class="nctouch-order-item-footer">
                            <div class="store-totle">
                                <time class="refund-time">
                                    <%=refund_list[i].return_add_time%>
                                </time>
                                <span class="refund-sum">退款金额：<em>￥<%=refund_list[i].return_cash%></em></span>
                            </div>
                            <div class="handle">
                                <a href="<%=WapSiteUrl%>/tmpl/order/member_refund_info.html?refund_id=<%=refund_list[i].order_return_id%>" class="btn evaluation-again-order">退款详情</a>
                            </div>
                        </div>
                    </div>
                </li>
                <%}%>
                    <% if (hasmore) {%>
                        <li class="loading">
                            <div class="spinner"><i></i></div>订单数据读取中...</li>
                        <% } %>
                            <%}else {%>
                                <div class="nctouch-norecord refund">
                                    <div class="norecord-ico"><i></i></div>
                                    <dl>
                                        <dt>您还没有退款信息</dt>
                                        <dd>已购订单详情可申请退款</dd>
                                    </dl>
                                </div>
                                <%}%>
    </script>
    <script type="text/javascript" src="../../js/libs/zepto.min.js"></script>
    <script type="text/javascript" src="../../js/libs/template.js"></script>
    
    <script type="text/javascript" src="../../js/common.js"></script>
    <script type="text/javascript" src="../../js/libs/simple-plugin.js"></script>
    <script type="text/javascript" src="../../js/libs/ncscroll-load.js"></script>
    <script type="text/javascript" src="../../js/tmpl/order/member_refund.js"></script>
    <script type="text/javascript" src="../../js/tmpl/footer.js"></script>
</body>

</html>

<?php 
include __DIR__ . '/../../includes/footer.php';
?>