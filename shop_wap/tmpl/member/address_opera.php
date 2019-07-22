<?php 
include __DIR__.'/../../includes/header.php';
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
    <title>新增收货地址</title>
    <link rel="stylesheet" type="text/css" href="../../css/base.css">
    <link rel="stylesheet" type="text/css" href="../../css/nctouch_member.css">
    <link rel="stylesheet" type="text/css" href="../../css/nctouch_common.css">
</head>

<body>
    <header id="header">
        <div class="header-wrap">
            <div class="header-l">
                <a href="address_list.html"> <i class="back"></i> </a>
            </div>
            <div class="header-title">
                <h1>新增收货地址</h1>
            </div>
            <div class="header-r"> <a id="header-nav" href="javascript:void(0);"><i class="save"></i></a> </div>
        </div>
    </header>
    <div class="nctouch-main-layout">
        <form>
            <div class="nctouch-inp-con">
                <ul class="form-box">
                    <li class="form-item">
                        <h4>收货人姓名</h4>
                        <div class="input-box">
                            <input type="text" class="inp" name="true_name" id="true_name" autocomplete="off" oninput="writeClear($(this));" />
                            <span class="input-del"></span> </div>
                    </li>
                    <li class="form-item">
                        <h4>联系手机</h4>
                        <div class="input-box">
                            <input type="tel" class="inp" name="mob_phone" id="mob_phone" autocomplete="off" oninput="writeClear($(this));" />
                            <span class="input-del"></span> </div>
                    </li>
                    <li class="form-item">
                        <h4>地区选择</h4>
                        <div class="input-box">
                            <input name="area_info" type="text" class="inp" id="area_info" autocomplete="off" onchange="btn_check($('form'));" readonly/>
                        </div>
                    </li>
                    <li class="form-item">
                        <h4>详细地址</h4>
                        <div class="input-box">
                            <input type="text" class="inp" name="address" id="address" autocomplete="off" oninput="writeClear($(this));">
                            <span class="input-del"></span> </div>
                    </li>
                    <li>
                        <h4>默认地址</h4>
                        <div class="input-box">
                            <label>
                                <input type="checkbox" class="checkbox" name="is_default" id="is_default" value="1" />
                                <span class="power"><i></i></span> </label>
                        </div>
                    </li>
                </ul>
                <div class="error-tips"></div>
                <div class="form-btn"><a class="btn" href="javascript:;">保存地址</a></div>
            </div>
        </form>
    </div>
    <footer id="footer" class="bottom"></footer>
    <script type="text/javascript" src="../../js/libs/zepto.min.js"></script>
    
    <script type="text/javascript" src="../../js/common.js"></script>
    <script type="text/javascript" src="../../js/libs/simple-plugin.js"></script>
    <script type="text/javascript" src="../../js/tmpl/footer.js"></script>
    <script type="text/javascript" src="../../js/tmpl/address/address_opera.js"></script>
</body>

</html>
<?php 
include __DIR__.'/../../includes/footer.php';
?>