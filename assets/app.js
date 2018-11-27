var url = "http://127.0.0.1/NYTimesApi/handler.php";
$('#search-submit').on('click', function () {
    var searchRequest = $('#search-text').val();
    if (searchRequest === '') {
        return true;
    }
    var params = '?' + $.param({
        'q': searchRequest
    });
    $.ajax({
        url: url + params,
        method: 'GET',
        dataType: "json"
    }).done(function (result) {
        console.log(result);
        $('#news').html('');
        $.each(result.response.docs, function (index, value) {
            var imageUrl = 'https://via.placeholder.com/75';
            if (value.multimedia.length != 0) {
                $.each(value.multimedia, function (indexMultimedia, valueMultimedia) {
                    if (valueMultimedia.subType == 'thumbnail') {
                        imageUrl = 'https://www.nytimes.com/' + valueMultimedia.url;
                    }
                });
            }
            var dateNews = new Date(value.pub_date);
            var htmlItemNews = '<div class="row news-item bg-light">\n' +
                '            <div class="media">\n' +
                '                <img class="align-self-center mr-3"\n' +
                '                     src="' + imageUrl + '"\n' +
                '                     alt="' + value.headline.main + '"' +
                '                     width="75px" height="75px">\n' +
                '                <div class="media-body">\n' +
                '                    <h4 class="mt-0">' + value.headline.main +
                '                        <small>' + value.byline.original + '</small>\n' +
                '                    </h4>\n' +
                '                    <h5 class="mt-0">' + dateNews.toDateString() + ' ' + dateNews.toTimeString() + '</h5>\n' +
                '                    <a href="' + value.web_url + '">Открыть\n' +
                '                        на сайте</a>\n' +
                '                </div>\n' +
                '            </div>\n' +
                '        </div>';
            $('#news').append(htmlItemNews);
        });
    });
});