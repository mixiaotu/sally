<?php
    include_once("./lib/init.php");
    if(session("isauth") != 1){
        redirect("/login.php");
    }
    $user = session('user');
    header("Content-type: text/html; charset=utf-8"); 
    $dir = $_SERVER['DOCUMENT_ROOT'].'/'.$_GET['dir'];
    $filenames = scandir($dir);
    foreach ($filenames as $key => $file) {
        if(substr($file,0,1) != "."){
            $encode = mb_detect_encoding($file, array("ASCII","UTF-8","GB2312","GBK","BIG5")); 
            if ($encode != "UTF-8"){ 
                $file = iconv($encode, 'UTF-8', $file);
            } 
            $path = $dir.'/'.$file;
            if(is_dir($path)){
                $dirs[] = $file;
            }else{
                $files[] =  $file;
            }
        }
    }
    rsort($dirs);
    rsort($files);
    $files = safe_array_merge($dirs,$files);
    $filter_array = array(".","..","index.php","login.php","logout.php",".svn","res","lib");
    $vsfiles = array_diff($files,$filter_array);
?>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>倩倩学习项目</title>
    <base href=".">
    <!--[if lte IE 9]>
    <script type="text/javascript">location.href = '/unsupport-browser.html';</script>
    <![endif]-->
    <link rel="stylesheet" href="/res/vendor.css">
    <link rel="stylesheet" href="/res/app.css">
    <style type="text/css">
        body{margin: 0;padding: 0;}
        .wrapper{width: 80%;margin: 0 10%;}
        .wrapper table{font-size: 12px;}
        #keyword{border:0;outline:none}
    </style>
</head>
<body class="coding-center coding" style="margin:0; padding:0">
    <div class="wrapper">
        <div>
            <div class="container">
                <div class="git-container">
                    <div class="tree">
                        <div cg-git-file-navigation="">
                            <div class="ui large breadcrumb tree-nav">
                                <div class="active nav-buttons">
                                    <a class="ui small button" href="javascript:;"> <i class="search icon"></i>
                                        <input type="text" class="form-control" placeholder="搜索" id="keyword">
                                    </a>
                                    <a class="ui small button" href="/logout.php"><i class="sign out icon"></i>退出</a>
                                </div>
                                <div class="nav-breadcrumb">
                                    <a class="active section" href="/"><?php echo $user['name']; ?></a>
                                    <div class="divider">/</div>
                                    <?php 
                                        $prearr = explode("/",rtrim($_GET['dir'],'/'));
                                        $_pre = "";
                                        foreach ($prearr as $key => $prepath) {
                                            if($key == count($prearr)-1){
                                    ?>
                                        <span ref="ref" path="path" context="tree">
                                            <span class="active section" style="display: inherit;">
                                                <span class="active section ng-binding">
                                                    <?php echo $prepath?>
                                                </span>
                                            </span>
                                        </span>
                                    <?php 
                                            }else{
                                            $_pre[] = $prepath;
                                    ?>
                                        <a class="active section" href="/<?php echo implode("/",$_pre)?>"><?php echo $prepath?></a>
                                        <div class="divider">/</div>
                                    <?php 
                                            }
                                        }
                                    ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="commit-tease">
                            <span class="coding floated right">
                                修改于
                                <time title="2016-12-14 16:39:43"><?php echo format_date(filemtime($dir));?></time>
                            </span>
                            <span class="commit-author-section">
                                <a href=javascript:;>
                                    <img class="author-gravatar" alt="@<?php echo $user['name']; ?>" width="20" height="20" src="<?php echo $user['avatar']; ?>"></a>
                                <span class="author-name">
                                    <a href=javascript:; title="<?php echo $user['name']; ?>"><?php echo $user['name']; ?></a>
                                </span>
                            </span>
                        </div>
                        <div class="files-list">
                            <table class="files">
                                <tbody>
                                    <?php
                                        if($_GET['dir'] && !in_array($_GET['dir'],array('/','..'))){
                                            $prearr = explode("/",rtrim($_GET['dir'],'/'));
                                            array_pop($prearr);
                                            if(count($prearr) > 0){
                                                $prepath = implode("/",$prearr);
                                            }else{
                                                $prepath = "/";
                                            }
                                            if(substr($prepath,0,1) != "/"){
                                                $prepath = "/".$prepath;
                                            }
                                    ?>
                                        <tr class="file-item" data-val="<?php echo $prepath?>" data-type="dir">
                                            <td class="content">
                                                <span class="truncate truncate-target">
                                                    <a class="file-item-a" href="javascript:;">
                                                        <i class="reply mail icon"></i>
                                                        ..
                                                    </a>
                                                </span>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    <?php
                                        }
                                    ?>
                                    <?php
                                        foreach ($vsfiles as $key => $file) {
                                            $path = $dir.'/'.$file;
                                            $format_filemtime = format_date(filemtime($path));
                                            $filemtime = date("Y-m-d H:i:s",filemtime($path));
                                            $filectime = date("Y-m-d",filemtime($path));
                                            $fileperms = fileperms($path);
                                            if(is_dir($path)){
                                    ?>
                                        <tr class="file-item" data-val="<?php echo $file?>" data-type="dir">
                                            <td class="icon">
                                                <i class="folder icon"></i>
                                            </td>
                                            <td class="content">
                                                <span class="truncate truncate-target">
                                                    <a class="file-item-a" href="javascript:;" title="<?php echo $file?>"><?php echo $file?></a>
                                                </span>
                                            </td>
                                            <td class="age">
                                                <span class="truncate truncate-target" title="<?php echo $filemtime; ?>"><?php echo $format_filemtime; ?></span>
                                            </td>
                                            <td class="committer">
                                                <span class="truncate truncate-target">

                                                    <a href=javascript:;>
                                                        <img class="author-gravatar" src="<?php echo $user['avatar']; ?>" title="<?php echo $user['name']; ?>" width="20" height="20"></a>
                                                </span>
                                            </td>
                                            <td class="name">
                                                <span class="truncate truncate-target">
                                                    <a href=javascript:;><?php echo $user['name']; ?></a>
                                                </span>
                                            </td>
                                            <td class="message">
                                                <span class="truncate truncate-target">
                                                    <a href="javascript:;"><?php echo "create on ".$filectime; ?></a>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php
                                            }else{
                                    ?>
                                        <tr class="file-item" data-val="<?php echo $file?>" data-type="file">
                                            <td class="icon">
                                                <i class="file outline icon"></i>
                                            </td>
                                            <td class="content">
                                                <span class="truncate truncate-target">
                                                    <a class="file-item-a" href="javascript:;" title="<?php echo $file?>"><?php echo $file?></a>
                                                </span>
                                            </td>
                                            <td class="age">
                                                <span class="truncate truncate-target" title="<?php echo $filemtime; ?>"><?php echo $format_filemtime; ?></span>
                                            </td>
                                            <td class="committer">
                                                <span class="truncate truncate-target">

                                                    <a href=javascript:;>
                                                        <img class="author-gravatar" src="<?php echo $user['avatar']; ?>" title="<?php echo $user['name']; ?>" width="20" height="20"></a>
                                                </span>
                                            </td>
                                            <td class="name">
                                                <span class="truncate truncate-target">
                                                    <a href=javascript:;><?php echo $user['name']; ?></a>
                                                </span>
                                            </td>
                                            <td class="message">
                                                <span class="truncate truncate-target">
                                                    <a href="javascript:;"><?php echo "create on ".$filectime; ?></a>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="cli_dialog_div"></div>
    <script src="/res/jquery.min.js"></script>
    <script type="text/javascript">
        var height = $(window).height() - parseInt($("#lefttree").css("padding-top"))-$("#lefttree").find(".panel-heading").height()-parseInt($("#filelist").css("padding-top"))*2-15;
        $("#filelist").css("max-height",height);
        $("#keyword").on("input",function(){
            var keyword = $(this).val();
            $(".file-item").each(function(){
                if($(this).text().indexOf(keyword) == -1){
                    $(this).hide();
                }else{
                    $(this).show();
                }
            })
        })
        $(document).on("click",".file-item-a",function(){
            var type = $(this).closest('tr').data("type");
            var val = $(this).closest('tr').data("val");
            if(type == "dir"){
                if(val == ".."){
                    // window.location.href = window.location.href+val;
                }else{
                    // console.log(window.location.href+val);
                    window.location.href = val;
                }
            }else{
                window.open(val)
            }
        })
    </script>
</body>
</html>