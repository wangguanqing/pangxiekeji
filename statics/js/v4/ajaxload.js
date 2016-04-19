$(function() {
    $(document).on("click", ".m-list-more", function() {
        var self = $(this);
        if (self.hasClass("disabled")) {
            return false;
        }
        self.addClass("disabled");

        var data = {
            name_py: catName,
            offset: self.attr("data-offset")
        };

        $.get(ajaxUrl, data, function(resp) {
            if (resp.code === 0) {
                $(".m-list-con").append(resp.data.html);
                self.attr("data-offset", resp.data.nextOffset);
                if (resp.data.nextOffset < 0) {
                    self.remove();
                }
            } else {
                alert("加载失败，请重试！");
            }

            self.removeClass("disabled");
        })
    })
});