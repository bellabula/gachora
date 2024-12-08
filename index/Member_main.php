<div id="member_name"></div>
<button id="memberbutton">post member id</button><br>
<button id="wall">戰牆</button>
<button id="coll">收藏</button>
<button id="stock">儲藏</button>
<button id="wallet">錢包</button>
<button id="go">訂單</button>
<button id="elem">基本</button>
<div id="info"></div>
<div id="result"></div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
  $(document).ready(function() {
    let member_id = 1
    $(document).on('click', '#memberbutton', function() {
      const url = '../Post/MainMember.php'
      $.post(url, {
        member_id: member_id
      }, ({
        name,
        gash,
        gift
      }) => {
        $('#info').text(`${name}, 有${gash}G幣`)
        gift.map((v, i) => {
          return $('#info').append(`<br>${v.amount}G幣將在${v.expire_at}過期`)
        })
      })
      const urlWall = '../Post/MemberWall.php'
      $.post(urlWall, {
        member_id: member_id
      }, ({
        egg,
        ichiban
      }) => {
        console.log(egg)
        egg.map((v) => {
          return $('#result').append(`<img style="width: 200px; margin: 20px;" src="${v.img}"/>`)
        })
        $('#result').append('<br>')
        ichiban.map((v) => {
          return $('#result').append(`<img style="width: 200px; margin: 20px;" src="${v.img}"/>`)
        })
      })

    })
    $('#coll').click(() => {
      const url = '../Post/MemberCollectionEgg.php'
      $.post(url, {
        member_id: member_id
      }, (response) => {
        console.log(response)
      })
    })
  })
</script>