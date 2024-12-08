<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<div id="type" style="display: none;"></div>
<button class="type" value="all">所有賞</button>
<button class="type" value="hot">熱銷賞</button>
<button class="type" value="new">新賞</button>
<button class="type" value="rare">稀有賞</button>
<div class="themes"></div>
<div class="pages"></div>
<div class="card"></div>
<script>
  $(document).ready(function() {
    // 蛋全域
    let category = 2
    // 首頁最下面精選商品
    fetch('../Fetch/MainIchiban.php')
      .then(response => response.json())
      .then(data => {
        console.log('精選：', data);
      })
      .catch(error => {
        console.error('Error fetching data:', error);
      })
    // 首頁上面top10
    fetch('../Fetch/MainEgg10.php')
      .then(response => response.json())
      .then(data => {
        console.log('Top 10：', data);
      })
      .catch(error => {
        console.error('Error fetching data:', error);
      })
    // 選擇不同大分類出現相應賞
    let type = ''
    let page = ''
    let tmpurl = ''
    let theme = ''
    $(document).on('click', '.type', function() {
      const url = '../Post/IchibanType.php'
      tmpurl = url
      type = $(this).val()
      $.post(url, {
        type: type,
        page: page
      }, (response) => {
        console.log('不同大分類', response);
        for (i = 1; i <= response.pages; i++) {
          $('.pages').text('')
          $('.pages').append(`<button class="page">${i}</button>`)
        }
        $('.card').text('')
        response.series.map((v) => {
          $('.card').append(`<button class="ichibanid">賞id${v.series_id}</button>`)
        })
      })
      // 分類頁所有主題
      fetch('../Fetch/IchibanTheme.php')
        .then(response => response.json())
        .then(data => {
          $('.themes').text('')
          data.map((v, i) => {
            $('.themes').append(`<button class="theme" value="${v}">${v}</button>`)
          })
        })
    })
    // 分類頁主題選擇
    $(document).on('click', '.theme', function() {
      $('#type').text($(this).val())
      const url = '../Post/IchibanThemeType.php'
      tmpurl = url
      page = $('#page').text()
      theme = $(this).val()
      $.post(url, {
        theme: theme,
        page: page
      }, (response) => {
        $('.card').text('')
        response.series.map((v) => {
          $('.card').append(`<button class="ichibanid">賞id${v.series_id}</button>`)
        })
        console.log('主題分類', response)
      })
    })
    // 分類頁選擇頁數
    $(document).on('click', '.page', function() {
      const url = tmpurl
      $.post(url, {
        theme: theme,
        type: type,
        page: $(this).text()
      }, (response) => {
        console.log('不同頁數', response)
      })
    })
    // 選賞跳到詳細頁
    $(document).on('click', '.ichibanid', function() {
      const url = '../Post/IchibanDetail.php'
      let series = $(this).text().substr(-1)
      $.post(url, {
        series_id: series
      }, (response) => {
        console.log('賞詳細頁', response);
      })
    })
  })
</script>