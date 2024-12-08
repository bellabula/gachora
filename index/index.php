<button id="ichiban">一番賞</button>
<button id="egg">蛋</button>
<button id="member">會員</button>
<script>
  document.getElementById('egg').onclick = () => {
    window.location.href = "Egg_main.php"
  }
  document.getElementById('ichiban').onclick = () => {
    window.location.href = "Ichiban_main.php"
  }
  document.getElementById('member').onclick = () => {
    window.location.href = "Member_main.php"
  }
</script>