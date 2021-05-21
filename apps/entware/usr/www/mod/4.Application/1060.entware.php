<html><head>
    <meta charset="utf-8">
    <title>Entware</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, width=device-width">
    <meta name="src" content="https://github.com/mpashka/terranas">
    <link href="/css/base.css" type="text/css" rel="stylesheet">
    <link href="/css/entware/entware.css" type="text/css" rel="stylesheet">
    <link href="/tos/static/style/font-awesome/css/font-awesome.css" type="text/css" rel="stylesheet">
    <script src="/js/jquery.js"></script>
    <script src="/js/wbox.js"></script>
    <script src="/js/layer/layer.js"></script>
    <script src="/js/common.js?v="></script>
    <script src="/js/entware/entware.js"></script>
    <link rel="stylesheet" href="/js/layer/skin/default/layer.css?v=3.0.11110" id="layuicss-skinlayercss">
</head>
<body>
<div class="main-body">
    <div class="menu-left">
        <ul id="menu-list">
            <li data-id="info"><i class="icon-info"></i><span>Overview</span></li>
            <li data-id="install"><i class="icon-download-alt"></i><span>Install</span></li>
            <li data-id="files"><i class="icon-folder-open-alt"></i><span>Files</span></li>
        </ul>
    </div>
    <div class="cont-right" id="content">
        <div data-id="info">
            <div class="info_title">Overview</div>

            <div class="container_body">
                <a href="https://github.com/Entware/Entware/wiki">Entware</a>
                is software repository for embedded devices like routers or network attached storages.
                <a href="http://bin.entware.net/armv7sf-k3.2/Packages.html">2500+ packages</a>
                are available.
                <br>
                Before using entware application you have to
                <button data-id="info_install">install</button> it.
                <br>
                In order to use entware packages usually you need remote access to your NAS (ssh or telnet).
                Please enable it in
                <b>Control panel/Terminal & SMTP</b> and then use software like <a href="https://www.putty.org/">PuTTY</a> on windows
                or <b>ssh</b> to login to your NAS and access command line.
            </div>
        </div>
        <div data-id="install">
            <div class="info_title">Install</div>

            <div class="container_body">
                <button class="button_icon10" data-id="install_button">
                    <i class="icon-ok-circle hide"></i>
                    <img src="/images/entware/spinner.svg" class="hide">
                    Install
                </button>
                <br>
                <div class="info_title">Logs</div>
                <div class="install_logs_container">
                    <pre data-id="install_logs">
                    </pre>
                </div>
            </div>
        </div>
        <div data-id="files">
            <iframe src="/tos/index.php?/explorer&type=iframe&path=/appdata/entware" class="files_iframe"></iframe>
        </div>
    </div>
</div>

<div class="layui-layer-move"></div>
</body></html>
