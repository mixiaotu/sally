<?php
    header("Content-type: text/html; charset=utf-8"); 
    $dir = $_SERVER['DOCUMENT_ROOT'].'/'.$_GET['dir'];
    $dh = @opendir($dir);
    while($file = @readdir($dh)){
        if(substr($file,0,1) != "."){
            $path = $dir.'/'.$file;
            $filetime[] = filectime($path); 
            $files[] =  $file;
        }
    }  
    @closedir($dh);
    array_multisort($filetime,SORT_DESC,SORT_NUMERIC, $files);
    $filter_array = array(".","..","index.php",".svn","res");
    $vsfiles = array_diff($files,$filter_array);

    function format_date($time) {
	    $nowtime = time();
	    $difference = $nowtime - $time;
	    switch ($difference) {
	        case $difference <= '60' :
	            $msg = '刚刚';
	            break;
	        case $difference > '60' && $difference <= '3600' :
	            $msg = floor($difference / 60) . '分钟前';
	            break;
	        case $difference > '3600' && $difference <= '86400' :
	            $msg = floor($difference / 3600) . '小时前';
	            break;
	        case $difference > '86400' && $difference <= '2592000' :
	            $msg = floor($difference / 86400) . '天前';
	            break;
	        case $difference > '2592000' &&  $difference <= '7776000':
	            $msg = floor($difference / 2592000) . '个月前';
	            break;
	        case $difference > '7776000':
	            $msg = '很久以前';
	            break;
	    }
	    return $msg;
	}
?>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>倩倩学习项目</title>
    <base href=".">
    <!--[if lte IE 9]>
    <script type="text/javascript">location.href = '/unsupport-browser.html';</script>
    <![endif]-->
    <link rel="stylesheet" href="./res/vendor.css">
    <link rel="stylesheet" href="./res/app.css">
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
                                </div>
                                <div class="nav-breadcrumb">
                                    <a class="active section" href="https://coding.net/u/banshan/p/sally/git/tree/master">sally</a>
                                    <div class="divider">/</div>
                                    <span ref="ref" path="path" context="tree">
                                        <span class="active section" style="display: inherit;">
                                            <span class="active section ng-binding"><?php echo $_GET['dir']; ?></span>
                                        </span>
                                    </span>
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
                                <a ng-href="/u/banshan" href="https://coding.net/u/banshan">
                                    <img class="author-gravatar" alt="@Jormin" width="20" height="20" src="./res/0a08a0d2d25e888a868b6e36dae450d6.jpg"></a>
                                <span class="author-name">
                                    <a href="https://coding.net/u/banshan" title="Jormin">Jormin</a>
                                </span>
                            </span>
                        </div>
                        <div class="files-list">
                            <table class="files">
                                <tbody>
                                    <?php
                                        if($_GET['dir'] && !in_array($_GET['dir'],array('/','..'))){
                                    ?>
                                        <tr>
                                            <td class="content">
                                                <span class="truncate truncate-target">
                                                    <a href="https://coding.net/u/banshan/p/sally/git/tree/master/">
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
                                        <tr  class="file-item" data-val="<?php echo $file?>">
                                            <td class="icon">
                                                <i class="folder icon"></i>
                                            </td>
                                            <td class="content">
                                                <span class="truncate truncate-target">
                                                    <a cg-ref="ref" href="javascript:;" title="<?php echo $file?>"><?php echo $file?></a>
                                                </span>
                                            </td>
                                            <td class="age">
                                                <span class="truncate truncate-target" title="<?php echo $filemtime; ?>"><?php echo $format_filemtime; ?></span>
                                            </td>
                                            <td class="committer">
                                                <span class="truncate truncate-target">

                                                    <a href="https://coding.net/u/banshan">
                                                        <img class="author-gravatar" src="./res/0a08a0d2d25e888a868b6e36dae450d6.jpg" title="Jormin" width="20" height="20"></a>
                                                </span>
                                            </td>
                                            <td class="name">
                                                <span class="truncate truncate-target">
                                                    <a href="https://coding.net/u/banshan">Jormin</a>
                                                </span>
                                            </td>
                                            <td class="message">
                                                <span class="truncate truncate-target">
                                                    <a href="https://coding.net/u/banshan/p/sally/git/commit/aa37d6040b1d748497fb5163ea47f8b4e73d33dc"><?php echo "create on ".$filectime; ?></a>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php
                                            }else{
                                    ?>
                                        <tr class="file-item" data-val="<?php echo $file?>">
                                            <td class="icon">
                                                <i class="file outline icon"></i>
                                            </td>
                                            <td class="content">
                                                <span class="truncate truncate-target">
                                                    <a cg-ref="ref" href="javascript:;" title="<?php echo $file?>"><?php echo $file?></a>
                                                </span>
                                            </td>
                                            <td class="age">
                                                <span class="truncate truncate-target" title="<?php echo $filemtime; ?>"><?php echo $format_filemtime; ?></span>
                                            </td>
                                            <td class="committer">
                                                <span class="truncate truncate-target">

                                                    <a href="https://coding.net/u/banshan">
                                                        <img class="author-gravatar" src="./res/0a08a0d2d25e888a868b6e36dae450d6.jpg" title="Jormin" width="20" height="20"></a>
                                                </span>
                                            </td>
                                            <td class="name">
                                                <span class="truncate truncate-target">
                                                    <a href="https://coding.net/u/banshan">Jormin</a>
                                                </span>
                                            </td>
                                            <td class="message">
                                                <span class="truncate truncate-target">
                                                    <a href="https://coding.net/u/banshan/p/sally/git/commit/aa37d6040b1d748497fb5163ea47f8b4e73d33dc"><?php echo "create on ".$filectime; ?></a>
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
    <script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
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
        $(document).on("click",".file-item",function(){
            var type = $(this).data("type");
            var val = $(this).data("val");
            if(type == "dir"){
                if(val == ".."){
                    window.location.href = window.location.href+val;
                }else{
                    window.location.href = window.location.href+val;
                }
            }else{

            }
        })
    </script>
</body>
</html>