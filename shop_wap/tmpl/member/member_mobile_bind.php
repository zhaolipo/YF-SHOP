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
    <title>手机验证</title>
    <link rel="stylesheet" type="text/css" href="../../css/base.css">
    <link rel="stylesheet" type="text/css" href="../../css/nctouch_member.css">
</head>

<body>
    <header id="header">
        <div class="header-wrap">
            <div class="header-l">
                <a href="member_account.html"> <i class="back"></i> </a>
            </div>
            <div class="header-title">
                <h1>手机验证</h1>
            </div>
        </div>
    </header>
    <div class="nctouch-main-layout">
        <div class="nctouch-inp-con">
            <form action="" method="">
                <ul class="form-box">

                    <li class="form-item">
                        <h4>手&nbsp;机&nbsp;号</h4>
                        <div class="input-box">
                            <input type="text" id="mobile" name="mobile" class="inp" autocomplete="off" maxlength="11" placeholder="输入手机号" oninput="writeClear($(this));" onfocus="writeClear($(this));" pattern="[0-9]*" />
                            <span class="input-del code"></span> <span class="code-countdown" style=" display: none;">
            <p>（等待<em>59</em>秒后）</p>
            <p>重新获取验证码</p>
            </span> <span class="code-again" style=""><a id="send" href="javascript: void(0);">获取短信验证</a></span> </div>
                    </li>
                    <!--
                    <li class="form-item">
                        <h4>验&nbsp;证&nbsp;码</h4>
                        <div class="input-box">
                            <input type="text" id="captcha" name="captcha" maxlength="4" size="10" class="inp" autocomplete="off" placeholder="输入图形验证码" oninput="writeClear($(this));" />
                            <span class="input-del code"></span>
                            <a href="javascript:void(0)" id="refreshcode" class="code-img"><img border="0" id="codeimage" name="codeimage"></a>
                            <input type="hidden" id="codekey" name="codekey" value="">
                        </div>
                    </li>
                    -->
                </ul>
            </form>
            <form action="" method="">
                <ul class="form-box mt5">
                    <li class="form-item">
                        <h4>动&nbsp;态&nbsp;码</h4>
                        <div class="input-box">
                            <input type="text" id="auth_code" readonly=true name="auth_code" class="inp" maxlength="6" placeholder="输入短信动态验证码" oninput="writeClear($(this));" onfocus="writeClear($(this));" pattern="[0-9]*" />
                            <span class="input-del"></span> </div>
                    </li>
                </ul>
                <div class="error-tips"></div>
                <div class="form-btn"><a href="javascript:void(0);" class="btn" id="nextform">下一步</a></div>
            </form>
            <div class="register-mobile-tip"> 小提示：通过手机验证后，可用于快速找回登录密码及支付密码，接收账户资产变更等提醒。</div>
        </div>
    </div>
    <footer id="footer" class="bottom"></footer>
    
    <script type="text/javascript" src="../../js/libs/zepto.min.js"></script>
    <script type="text/javascript" src="../../js/libs/template.js"></script>
    <script type="text/javascript" src="../../js/common.js"></script>
    <script type="text/javascript" src="../../js/libs/simple-plugin.js"></script>
    <script type="text/javascript" src="../../js/tmpl/member/member_mobile_bind.js"></script>
    <script type="text/javascript" src="../../js/tmpl/footer.js"></script>
</body>

</html>
<?php 
include __DIR__.'/../../includes/footer.php';
?>