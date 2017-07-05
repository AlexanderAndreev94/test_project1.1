/**
 * Created by alexander.andreev on 05.07.2017.
 */
$(document).ready(function(){
    $("#nextButton").click(function () {
        var category = $(this).attr("catId");
        var offset = $(this).attr("offsetId");

        $.ajax({
            type: 'GET',
            url: 'index.php?r=main/home&catId='+category+'&offsetId='+offset,
            success: function(data)
            {
                var decData = JSON.parse(data);
                $(".article").remove();

                for(var i = 0; i < decData.length; i++)
                {
                    $('<div class="article">'+
                        '<div class="articleHeader">' +
                        '<div class="name">'+
                        '<p><a href="index.php?r=main/show&id=' + decData[i].id + '">' + decData[i].title + '</a></p>' +
                        '</div>'+
                        '<div class="postDate">' +
                        '<p>' + decData[i].pub_date + '</p>' +
                        '</div>'+
                        '</div>' +
                        '</div>').insertBefore(".nextBtn");
                }
            }
        });
    });
});