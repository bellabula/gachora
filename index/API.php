<?php
require_once __DIR__ . '/Connect.php';
class API
{
  // 扭蛋主頁fetch
  // 精選
  function EggBling()
  {
    $db = new Connect;
    $jsonOutput = [];
    $sql1 = "select * from vw_blingEgg";
    $stmt1 = $db->prepare($sql1);
    $stmt1->execute();
    while ($output1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
      $series_id = $output1['series_id'];
      $sql2 = "select * from vw_series_img where series_id = :series_id";
      $stmt2 = $db->prepare($sql2);
      $stmt2->bindValue(':series_id', $series_id, PDO::PARAM_INT);
      $stmt2->execute();
      $img = [];
      while ($output2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $img[] = $output2['series_img'];
      }
      $jsonOutput[] = [
        'series_id' => $output1['series_id'],
        'theme' => $output1['theme'],
        'title' => $output1['series_title'],
        'name' => $output1['name'],
        'price' => $output1['price'],
        'amount' => $output1['amount'],
        'img' => $img
      ];
    }
    $db = null;
    return json_encode($jsonOutput);
    unset($jsonOutput);
  }
  // top 10 要加php timestamp修
  function EggTop10()
  {
    $db = new Connect;
    $jsonOutput = [];
    $sql1 = "select * from vw_hotEgg limit 10";
    $stmt1 = $db->prepare($sql1);
    $stmt1->execute();
    while ($output1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
      $series_id = $output1['series_id'];
      $sql2 = "select * from vw_series_img where series_id = :series_id";
      $stmt2 = $db->prepare($sql2);
      $stmt2->bindValue(':series_id', $series_id, PDO::PARAM_INT);
      $stmt2->execute();
      $img = [];
      while ($output2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $img[] = $output2['series_img'];
      }
      $jsonOutput[] = [
        'series_id' => $output1['series_id'],
        'theme' => $output1['theme'],
        'title' => $output1['series_title'],
        'name' => $output1['name'],
        'price' => $output1['price'],
        'amount' => $output1['amount'],
        'img' => $img
      ];
    }
    $db = null;
    return json_encode($jsonOutput);
    unset($jsonOutput);
  }
  // 扭蛋主頁post
  function EggType($type, $page)
  {
    $type = $_POST['type'];
    $db = new Connect;
    $jsonOutput = [];
    if (is_null($type)) {
      $sql1 = "select * from vw_allEgg limit :page, 24";
      $sql2 = "select count(*) from vw_allEgg";
    }
    if ($type == 'all') {
      $sql1 = "select * from vw_allEgg limit :page, 24";
      $sql2 = "select count(*) from vw_allEgg";
    }
    if ($type == 'hot') {
      $sql1 = "select * from vw_hotEgg limit :page, 24";
      $sql2 = "select count(*) from vw_hotEgg";
    }
    if ($type == 'rare') {
      $sql1 = "select * from vw_rareEgg limit :page, 24";
      $sql2 = "select count(*) from vw_rareEgg";
    }
    if ($type == 'new') {
      $sql1 = "select * from vw_newEgg limit :page, 24";
      $sql2 = "select count(*) from vw_newEgg";
    }
    $stmt1 = $db->prepare($sql1);
    $stmt2 = $db->prepare($sql2);
    $stmt1->bindValue(':page', ($page - 1) * 24, PDO::PARAM_STR);
    $stmt1->execute();
    $stmt2->execute();
    while ($output = $stmt1->fetch(PDO::FETCH_ASSOC)) {
      $series_id = $output['series_id'];
      $sql3 = "select * from vw_series_img where series_id = :series_id";
      $stmt3 = $db->prepare($sql3);
      $stmt3->bindValue(':series_id', $series_id, PDO::PARAM_INT);
      $stmt3->execute();
      $img = [];
      while ($output3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
        $img[] = $output3['series_img'];
      }
      $jsonOutput['series'][] = [
        'series_id' => $output['series_id'],
        'theme' => $output['theme'],
        'title' => $output['series_title'],
        'name' => $output['name'],
        'price' => $output['price'],
        'amount' => $output['amount'],
        'img' => $img
      ];
    }
    while ($output = $stmt2->fetch(PDO::FETCH_ASSOC)) {
      $jsonOutput['pages'] = floor($output['count(*)'] / 24) + 1;
    }
    $db = null;
    return json_encode($jsonOutput);
    unset($jsonOutput);
  }
  // 扭蛋分類fetch
  // 主題顯示
  function Theme()
  {
    $db = new Connect;
    $jsonOutput = [];
    $sql1 = "select Theme from vw_theme m left join Theme t on m.theme_id = t.id where category_id = 1 group by Theme";
    $stmt1 = $db->prepare($sql1);
    $stmt1->execute();
    while ($output1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
      $jsonOutput[] = $output1['Theme'];
    }
    $db = null;
    return json_encode($jsonOutput);
    unset($jsonOutput);
  }
  // 扭蛋分類post
  function ThemeSort($theme, $page)
  {
    $theme = $_POST['theme'];
    $db = new Connect;
    $jsonOutput = [];
    $sql1 = "select * from vw_eggcard where theme = :theme limit :page, 24";
    $sql2 = "select count(*) from vw_eggcard";

    $stmt1 = $db->prepare($sql1);
    $stmt2 = $db->prepare($sql2);
    $stmt1->bindValue(':theme', $theme, PDO::PARAM_STR);
    $stmt1->bindValue(':page', ($page - 1) * 24, PDO::PARAM_STR);
    $stmt1->execute();
    $stmt2->execute();
    $jsonOutput['series'] = [];
    while ($output = $stmt1->fetch(PDO::FETCH_ASSOC)) {
      $series_id = $output['series_id'];
      $sql3 = "select * from vw_EggCardImg where series_id = :series_id";
      $stmt3 = $db->prepare($sql3);
      $stmt3->bindValue(':series_id', $series_id, PDO::PARAM_INT);
      $stmt3->execute();
      $img = [];
      while ($output3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
        $img[] = $output3['series_img'];
      }
      $jsonOutput['series'][] = [
        'series_id' => $output['series_id'],
        'theme' => $output['theme'],
        'title' => $output['series_title'],
        'name' => $output['name'],
        'price' => $output['price'],
        'amount' => $output['amount'],
        'img' => $img
      ];
    }
    while ($output = $stmt2->fetch(PDO::FETCH_ASSOC)) {
      $jsonOutput['pages'] = floor($output['count(*)'] / 24) + 1;
    }
    $db = null;
    return json_encode($jsonOutput);
    unset($jsonOutput);
  }

  // 扭蛋詳細post
  function EggDetail($series_id)
  {
    $series_id = $_POST['series_id'];
    $db = new Connect;
    $jsonOutput = [];
    $sql = "select * from vw_detail where series_id = :series_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':series_id', $series_id, PDO::PARAM_INT);
    $stmt->execute();
    $sql1 = "select * from vw_blingEgg where series_id = :series_id";
    $stmt1 = $db->prepare($sql1);
    $stmt1->bindValue(':series_id', $series_id, PDO::PARAM_INT);
    $stmt1->execute();
    while ($output1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
      $series_id = $output1['series_id'];
      $theme = $output1['theme'];
      $sql2 = "select * from vw_series_img where series_id = :series_id";
      $stmt2 = $db->prepare($sql2);
      $stmt2->bindValue(':series_id', $series_id, PDO::PARAM_INT);
      $stmt2->execute();
      $img = [];
      while ($output2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $img[] = $output2['series_img'];
      }
      $jsonOutput['series'][] = [
        'series_id' => $output1['series_id'],
        'theme' => $output1['theme'],
        'title' => $output1['series_title'],
        'name' => $output1['name'],
        'price' => $output1['price'],
        'amount' => $output1['amount'],
        'img' => $img
      ];
    }
    while ($output = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $jsonOutput['character'][] = [
        'prize' => $output['prize'],
        'name' => $output['character_name'],
        'img' => $output['character_img'],
        'size' => $output['size'],
        'material' => $output['material'],
      ];
    }
    // 扭蛋詳細推薦
    $sql1 = "select * from vw_eggcard where theme = :theme limit 10";
    $sql2 = "select count(*) from vw_eggcard";

    $stmt1 = $db->prepare($sql1);
    $stmt2 = $db->prepare($sql2);
    $stmt1->bindValue(':theme', $theme, PDO::PARAM_STR);
    $stmt1->execute();
    $stmt2->execute();
    $jsonOutput['recommend'] = [];
    while ($output = $stmt1->fetch(PDO::FETCH_ASSOC)) {
      $series_id = $output['series_id'];
      $sql3 = "select * from vw_EggCardImg where series_id = :series_id";
      $stmt3 = $db->prepare($sql3);
      $stmt3->bindValue(':series_id', $series_id, PDO::PARAM_INT);
      $stmt3->execute();
      $img = [];
      while ($output3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
        $img[] = $output3['series_img'];
      }
      $jsonOutput['recommend'][] = [
        'series_id' => $output['series_id'],
        'theme' => $output['theme'],
        'title' => $output['series_title'],
        'name' => $output['name'],
        'price' => $output['price'],
        'amount' => $output['amount'],
        'img' => $img
      ];
    }
    // 扭蛋剩餘
    $sql4 = "call GetAmountById(:series_id)";
    $stmt4 = $db->prepare($sql4);
    $stmt4->bindValue(':series_id', $series_id, PDO::PARAM_INT);
    $stmt4->execute();
    while ($output4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
      $jsonOutput['series'][0] += [
        'remain' => $output4['remain'],
        'total' => $output4['total']
      ];
    }
    $db = null;
    return json_encode($jsonOutput);
    unset($jsonOutput);
  }

  // 地址
  function City($input)
  {
    $db = new Connect;
    $jsonOutput = [];
    $sql = "SELECT * from City where id = $input";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    while ($output = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $jsonOutput[$output['id']] = [
        'id' => $output['id'],
        'city' => $output['city']
      ];
    }
    $db = null;
    return json_encode($jsonOutput);
    unset($jsonOutput);
  }
  //一番賞首
  //精選
  function IchibanBling()
  {
    $db = new Connect;
    $jsonOutput = [];
    $sql1 = "select series_id, theme_id, theme, series_title, name, price from vw_ichiban order by release_time";
    $stmt1 = $db->prepare($sql1);
    $stmt1->execute();
    while ($output1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
      $series_id = $output1['series_id'];
      $sql2 = "select * from vw_IchibanImg where series_id = :series_id";
      $stmt2 = $db->prepare($sql2);
      $stmt2->bindValue(':series_id', $series_id, PDO::PARAM_INT);
      $stmt2->execute();
      $img = [];
      while ($output2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $img[] = $output2['series_img'];
      }
      // 數量
      $sql3 = "select all_remain, all_amount from vw_IchibanRemainTotal where series_id = :series_id";
      $stmt3 = $db->prepare($sql3);
      $stmt3->bindValue(':series_id', $series_id, PDO::PARAM_INT);
      $stmt3->execute();
      while ($output3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
        $array2 = [
          'remain' => $output3['all_remain'],
          'total' => $output3['all_amount']
        ];
      }
      $sql4 = "select prize, name, remain, amount from vw_RemainTotal where series_id = :series_id";
      $stmt4 = $db->prepare($sql4);
      $stmt4->bindValue(':series_id', $series_id, PDO::PARAM_INT);
      $stmt4->execute();
      $character = [];
      while ($output4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
        $character[] = [
          'prize' => $output4['prize'],
          'name' => $output4['name'],
          'remain' => $output4['remain'],
          'total' => $output4['amount']
        ];
      }
      $array1 = [
        'series_id' => $output1['series_id'],
        'theme' => $output1['theme'],
        'title' => $output1['series_title'],
        'name' => $output1['name'],
        'price' => $output1['price'],
        'img' => $img,
        'character' => $character
      ];
      $jsonOutput[] = array_merge($array1, $array2);
    }
    $db = null;
    return json_encode($jsonOutput);
    unset($jsonOutput);
  }
  // 賞主頁post
  function IchibanType($type, $page)
  {
    $type = $_POST['type'];
    $db = new Connect;
    $jsonOutput = [];
    if (is_null($type)) {
      $sql1 = "select series_id, theme_id, theme, series_title, name, price from vw_ichiban order by stock desc limit :page, 24";
    }
    if ($type == 'all' || $type == 'hot') {
      $sql1 = "select series_id, theme_id, theme, series_title, name, price from vw_ichiban order by stock desc limit :page, 24";
    }
    if ($type == 'rare') {
      $sql1 = "select series_id, theme_id, theme, series_title, name, price from vw_ichiban order by stock limit :page, 24";
    }
    if ($type == 'new') {
      $sql1 = "select series_id, theme_id, theme, series_title, name, price from vw_ichiban order by release_time desc limit :page, 24";
    }
    $stmt1 = $db->prepare($sql1);
    $stmt1->bindValue(':page', ($page - 1) * 24, PDO::PARAM_INT);
    $stmt1->execute();
    while ($output1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
      $series_id = $output1['series_id'];
      $sql2 = "select * from vw_IchibanImg where series_id = :series_id";
      $stmt2 = $db->prepare($sql2);
      $stmt2->bindValue(':series_id', $series_id, PDO::PARAM_INT);
      $stmt2->execute();
      $img = [];
      while ($output2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $img[] = $output2['series_img'];
      }
      // 數量
      $sql3 = "select all_remain, all_amount from vw_IchibanRemainTotal where series_id = :series_id";
      $stmt3 = $db->prepare($sql3);
      $stmt3->bindValue(':series_id', $series_id, PDO::PARAM_INT);
      $stmt3->execute();
      while ($output3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
        $array2 = [
          'remain' => $output3['all_remain'],
          'total' => $output3['all_amount']
        ];
      }
      $sql4 = "select prize, name, remain, amount from vw_RemainTotal where series_id = :series_id";
      $stmt4 = $db->prepare($sql4);
      $stmt4->bindValue(':series_id', $series_id, PDO::PARAM_INT);
      $stmt4->execute();
      $character = [];
      while ($output4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
        $character[] = [
          'prize' => $output4['prize'],
          'name' => $output4['name'],
          'remain' => $output4['remain'],
          'total' => $output4['amount']
        ];
      }
      $array1 = [
        'series_id' => $output1['series_id'],
        'theme' => $output1['theme'],
        'title' => $output1['series_title'],
        'name' => $output1['name'],
        'price' => $output1['price'],
        'img' => $img,
        'character' => $character
      ];
      $jsonOutput['series'][] = array_merge($array1, $array2);
      $sql2 = "select count(*) from vw_IchibanImg";
      $stmt2 = $db->prepare($sql2);
      $stmt2->execute();
      while ($output = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $jsonOutput['pages'] = floor($output['count(*)'] / 24) + 1;
      }
    }
    $db = null;
    return json_encode($jsonOutput);
    unset($jsonOutput);
  }
  // 賞分類post
  function IchibanThemeSort($theme, $page)
  {
    $theme = $_POST['theme'];
    $db = new Connect;
    $jsonOutput = [];
    $sql1 = "select * from vw_Ichiban where theme = :theme limit :page, 24";
    $stmt1 = $db->prepare($sql1);
    $stmt1->bindValue(':theme', $theme, PDO::PARAM_STR);
    $stmt1->bindValue(':page', ($page - 1) * 24, PDO::PARAM_INT);
    $stmt1->execute();
    while ($output1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
      $series_id = $output1['series_id'];
      $sql2 = "select * from vw_IchibanImg where series_id = :series_id";
      $stmt2 = $db->prepare($sql2);
      $stmt2->bindValue(':series_id', $series_id, PDO::PARAM_INT);
      $stmt2->execute();
      $img = [];
      while ($output2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $img[] = $output2['series_img'];
      }
      // 數量
      $sql3 = "select all_remain, all_amount from vw_IchibanRemainTotal where series_id = :series_id";
      $stmt3 = $db->prepare($sql3);
      $stmt3->bindValue(':series_id', $series_id, PDO::PARAM_INT);
      $stmt3->execute();
      while ($output3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
        $array2 = [
          'remain' => $output3['all_remain'],
          'total' => $output3['all_amount']
        ];
      }
      $sql4 = "select prize, name, remain, amount from vw_RemainTotal where series_id = :series_id";
      $stmt4 = $db->prepare($sql4);
      $stmt4->bindValue(':series_id', $series_id, PDO::PARAM_INT);
      $stmt4->execute();
      $character = [];
      while ($output4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
        $character[] = [
          'prize' => $output4['prize'],
          'name' => $output4['name'],
          'remain' => $output4['remain'],
          'total' => $output4['amount']
        ];
      }
      $array1 = [
        'series_id' => $output1['series_id'],
        'theme' => $output1['theme'],
        'title' => $output1['series_title'],
        'name' => $output1['name'],
        'price' => $output1['price'],
        'img' => $img,
        'character' => $character
      ];
      $jsonOutput['series'][] = array_merge($array1, $array2);
      $sql2 = "select count(*) from vw_Ichiban";
      $stmt2 = $db->prepare($sql2);
      $stmt2->execute();
      while ($output = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $jsonOutput['pages'] = floor($output['count(*)'] / 24) + 1;
      }
    }
    $db = null;
    return json_encode($jsonOutput);
    unset($jsonOutput);
  }
  // 一番賞種類
  function IchibanTheme()
  {
    $db = new Connect;
    $jsonOutput = [];
    $sql1 = "select Theme from vw_theme m left join Theme t on m.theme_id = t.id where category_id = 2 group by Theme";
    $stmt1 = $db->prepare($sql1);
    $stmt1->execute();
    while ($output1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
      $jsonOutput[] = $output1['Theme'];
    }
    $db = null;
    return json_encode($jsonOutput);
    unset($jsonOutput);
  }
  // 賞詳細post
  function IchibanDetail($series_id)
  {
    $series_id = $_POST['series_id'];
    $db = new Connect;
    $jsonOutput = [];
    $sql1 = "select series_id, theme_id, theme, series_title, name, price from vw_ichiban where series_id = :series_id";
    $stmt1 = $db->prepare($sql1);
    $stmt1->bindValue(':series_id', $series_id, PDO::PARAM_INT);
    $stmt1->execute();
    while ($output1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
      $sql2 = "select * from vw_IchibanImg where series_id = :series_id";
      $stmt2 = $db->prepare($sql2);
      $stmt2->bindValue(':series_id', $series_id, PDO::PARAM_INT);
      $stmt2->execute();
      $img = [];
      while ($output2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $img[] = $output2['series_img'];
      }
      // 數量
      $sql3 = "select all_remain, all_amount from vw_IchibanRemainTotal where series_id = :series_id";
      $stmt3 = $db->prepare($sql3);
      $stmt3->bindValue(':series_id', $series_id, PDO::PARAM_INT);
      $stmt3->execute();
      while ($output3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
        $array0 = [
          'remain' => $output3['all_remain'],
          'total' => $output3['all_amount']
        ];
      }
      //character
      $sql4 = "select prize, name, remain, amount from vw_RemainTotal where series_id = :series_id";
      $stmt4 = $db->prepare($sql4);
      $stmt4->bindValue(':series_id', $series_id, PDO::PARAM_INT);
      $stmt4->execute();
      $character = [];
      while ($output4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
        $array1[] = [
          'prize' => $output4['prize'],
          'name' => $output4['name'],
          'remain' => $output4['remain'],
          'total' => $output4['amount']
        ];
      }
      $sql5 = "select character_img, size, material from vw_detail where series_id = :series_id";
      $stmt5 = $db->prepare($sql5);
      $stmt5->bindValue(':series_id', $series_id, PDO::PARAM_INT);
      $stmt5->execute();
      $character = [];
      while ($output5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
        $array2[] = [
          'img' => $output5['character_img'],
          'size' => $output5['size'],
          'material' => $output5['material'],
        ];
      }
      foreach ($array1 as $index => $element) {
        $character[] = array_merge($element, $array2[$index]);
      }
      $theme = $output1['theme'];
      $array3 = [
        'series_id' => $output1['series_id'],
        'theme' => $output1['theme'],
        'title' => $output1['series_title'],
        'name' => $output1['name'],
        'price' => $output1['price'],
        'img' => $img,
        'character' => $character
      ];
      $jsonOutput['series'][] = array_merge($array0, $array3);
    }
    // 賞主題推薦
    $sql1 = "select * from vw_Ichiban where theme = :theme limit 10";
    $stmt1 = $db->prepare($sql1);
    $stmt1->bindValue(':theme', $theme, PDO::PARAM_STR);
    $stmt1->execute();
    while ($output1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
      $series_id = $output1['series_id'];
      $sql2 = "select * from vw_IchibanImg where series_id = :series_id";
      $stmt2 = $db->prepare($sql2);
      $stmt2->bindValue(':series_id', $series_id, PDO::PARAM_INT);
      $stmt2->execute();
      $img = [];
      while ($output2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $img[] = $output2['series_img'];
      }
      $sql4 = "select prize, name, remain, amount from vw_RemainTotal where series_id = :series_id";
      $stmt4 = $db->prepare($sql4);
      $stmt4->bindValue(':series_id', $series_id, PDO::PARAM_INT);
      $stmt4->execute();
      $character = [];
      while ($output4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
        $character[] = [
          'prize' => $output4['prize'],
          'name' => $output4['name'],
          'remain' => $output4['remain'],
          'total' => $output4['amount']
        ];
      }
      $array5 = [
        'series_id' => $output1['series_id'],
        'theme' => $output1['theme'],
        'title' => $output1['series_title'],
        'name' => $output1['name'],
        'price' => $output1['price'],
        'img' => $img,
        'character' => $character
      ];
      // 數量
      $sql3 = "select all_remain, all_amount from vw_IchibanRemainTotal where series_id = :series_id";
      $stmt3 = $db->prepare($sql3);
      $stmt3->bindValue(':series_id', $series_id, PDO::PARAM_INT);
      $stmt3->execute();
      while ($output3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
        $array3 = [
          'remain' => $output3['all_remain'],
          'total' => $output3['all_amount']
        ];
      }
      $jsonOutput['recommend'][] = array_merge($array3, $array5);
      // 已抽籤號
      $sql = "call GetLabelById(:series_id)";
      $stmt = $db->prepare($sql);
      $stmt->bindValue(':series_id', $series_id, PDO::PARAM_INT);
      $stmt->execute();
      while ($output = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $jsonOutput['label'][] = $output['label'];
      }
    }
    $db = null;
    return json_encode($jsonOutput);
    unset($jsonOutput);
  }
  function Member($member_id)
  {
    $member_id = $_POST['member_id'];
    $db = new Connect;
    $jsonOutput = [];
    $sql = "call GetMemberNameById(:member_id);";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
    $stmt->execute();
    while ($output = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $jsonOutput['name'] = $output['name'];
    }
    $stmt->closeCursor();
    $sql = "call GetGashNowById(:member_id);";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
    $stmt->execute();
    while ($output = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $jsonOutput['gash'] = $output['gash'];
    }
    $stmt->closeCursor();
    $sql = "call GetGiftExpireDateById(:member_id);";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
    $stmt->execute();
    while ($output = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $jsonOutput['gift'][] = [
        'amount' => $output['gift'],
        'expire_at' => date('Y-m-d H:i:s', $output['expire_at'])
      ];
    }
    $stmt->closeCursor();
    $db = null;
    return json_encode($jsonOutput);
    unset($jsonOutput);
  }
  function Wall($member_id)
  {
    $member_id = $_POST['member_id'];
    $db = new Connect;
    $jsonOutput = [];
    $sql = "call GetRecordsByIdAndCategory(:member_id, 1);";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
    $stmt->execute();
    while ($output = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $jsonOutput['egg'][] = [
        'img' => $output['img']
      ];
    }
    $stmt->closeCursor();
    $sql = "call GetRecordsByIdAndCategory(:member_id, 2);";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
    $stmt->execute();
    while ($output = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $jsonOutput['ichiban'][] = [
        'img' => $output['img']
      ];
    }
    $stmt->closeCursor();
    $db = null;
    return json_encode($jsonOutput);
    unset($jsonOutput);
  }
  function CollectionEgg($member_id)
  {
    $member_id = $_POST['member_id'];
    $db = new Connect;
    $jsonOutput = [];
    $jsonOutput['hasseries'] = [];
    $jsonOutput['noseries'] = [];
    $sql = "call GetCollectionHasById(:member_id, 1);";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
    $stmt->execute();
    while ($output = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $jsonOutput['hasseries'][] = [
        'id' => $output['series_id'],
        'title' => $output['series_title'],
        'name' => $output['series_name'],
        'price' => $output['price'],
      ];
    }
    $stmt->closeCursor();
    $sql = "call GetCollectionNoById(:member_id, 1);";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
    $stmt->execute();
    while ($output = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $jsonOutput['noseries'][] = [
        'id' => $output['series_id'],
        'title' => $output['series_title'],
        'name' => $output['series_name'],
        'price' => $output['price'],
      ];
    }
    $stmt->closeCursor();

    $db = null;
    return json_encode($jsonOutput);
    unset($jsonOutput);
  }
}
