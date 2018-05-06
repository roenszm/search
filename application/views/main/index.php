<?php $this->load->view('common/header');?>
    <div>
        搜索网址为：<input value="<?php echo $search_url;?>" id="search-url" style="width:30%;">
        搜索文件名为：<input id="search-file" style="width:30%;">
        <a class="btn btn-primary" onclick="do_search()">执行</a>
        <div class="alert alert-info message">
            此功能用于在输入的搜索网址的页面element中搜索指定的文件名，返回匹配结果。
        </div>
        <h4>匹配结果：</h4>
        <pre id="search-result" class="alert alert-warning" style="width:100%;word-break: break-all;word-wrap:break-word;white-space:pre-wrap;"></pre>
        <h4>请求网页element：</h4>
        <div id="output" class="alert alert-warning"></div>
    </div>
    <script>

        function do_search() {
            $(".message").html("正在请求中，请稍后...");
            $.get(
                "<?php echo site_url('/index/search')?>",
                {
                    url: $("#search-url").val(),
                    file: $("#search-file").val()
                },
                function(data, status) {
                    data = $.parseJSON(data);
                    if (data["error"] != null || data["error"] != undefined) {
                        alert(data["error"]);
                        return false;
                    }
                    result = "匹配次数：" + data.times;
                    if (data["matches"].length > 0) {
                        if (data["matches"][0].length > 0) {
                            result += "\n匹配结果：\n";
                            for (i=0;i<data["matches"][0].length;i++) {
                                result += (i+1) + ". " + data["matches"][0][i] + "\n\n\n";
                            }
                        }
                    }
                    $("#output").text(data.output);
                    $("#search-result").text(result);
                    $(".message").html("请求完成。");
                }
            );
        }
    </script>
<?php $this->load->view('common/footer');?>