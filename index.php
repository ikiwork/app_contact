<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0">

<title>ご意見、お問い合わせフォーム</title>
</head>
<script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="./js/faq.js"></script>
<link rel="stylesheet" href="css/style.css">
<body>
<h1>よくあるご質問</h1>
<div class="accordion">

<div class="section ac">

  <div class="accordion_one">
    <div class="accordion_header">アコーディオンで多階層のメニューを作る<div class="i_box"><i class="one_i"></i></div></div>
    <div class="accordion_inner">
      <div class="accordion_one">
        <div class="accordion_header">A<div class="i_box"><i class="one_i"></i></div></div>
        <div class="accordion_inner">
          <div class="accordion_one">
            <div class="accordion_header">A_a</div>
            <div class="accordion_header">A_b</div>
          </div>
        </div>
      </div>
      <div class="accordion_one">
        <div class="accordion_header">B<div class="i_box"><i class="one_i"></i></div></div>
        <div class="accordion_inner">
          <div class="accordion_one">
            <div class="accordion_header">B_a</div>
            <div class="accordion_header">B_b</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="accordion_one">
    <div class="accordion_header">アコーディオンで多階層のメニューを作る<div class="i_box"><i class="one_i"></i></div></div>
    <div class="accordion_inner">
      <div class="accordion_one">
        <div class="accordion_header">A<div class="i_box"><i class="one_i"></i></div></div>
        <div class="accordion_inner">
          <div class="accordion_one">
            <div class="accordion_header">A_a</div>
            <div class="accordion_header">A_b</div>
          </div>
        </div>
      </div>
      <div class="accordion_one">
        <div class="accordion_header">B<div class="i_box"><i class="one_i"></i></div></div>
        <div class="accordion_inner">
          <div class="accordion_one">
            <div class="accordion_header">B_a</div>
            <div class="accordion_header">B_b</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="accordion_one">
    <div class="accordion_header">アコーディオンで多階層のメニューを作る<div class="i_box"><i class="one_i"></i></div></div>
    <div class="accordion_inner">
      <div class="accordion_one">
        <div class="accordion_header">A<div class="i_box"><i class="one_i"></i></div></div>
        <div class="accordion_inner">
          <div class="accordion_one">
            <div class="accordion_header">A_a</div>
            <div class="accordion_header">A_b</div>
          </div>
        </div>
      </div>
      <div class="accordion_one">
        <div class="accordion_header">B<div class="i_box"><i class="one_i"></i></div></div>
        <div class="accordion_inner">
          <div class="accordion_one">
            <div class="accordion_header">B_a</div>
            <div class="accordion_header">B_b</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</div>



<h1>ご意見、お問い合わせフォーム</h1>
<div class="coution"><label><span>*</span></label>全必須項目</div>
<?php
// 変数（フラグ）の初期化
$flag = 0;

// エスケープ処理後のデータを格納するための変数
$esc = array();

// エスケープ処理
if ( !empty( $_POST ) ) {
  foreach ( $_POST as $key => $value ) {
    $esc[ $key ] = htmlspecialchars( $value, ENT_QUOTES );
  }
}

// バリデーションエラーを格納するための変数
$error = array();

// バリデーション関数
function validation( $data ) {
  $error = array();

  if ( empty( $data[ 'username' ] ) ) {
    $error[] = "「お名前」をご入力ください";
  }

  if ( empty( $data[ 'email' ] ) ) {
    $error[] = "「メールアドレス」をご入力してください";
  } elseif ( !preg_match( '/^[0-9a-z_.\/?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$/', $data[ 'email' ] ) ) {
    $error[] = "「メールアドレス」は正しい形式でご入力ください";
  }

  if ( empty( $data[ 'message' ] ) ) {
    $error[] = "「お問い合わせ内容」をご入力ください";
  }

  return $error;
}


// 状況に応じてフラグの切り替え
if ( !empty( $esc[ 'confirm' ] ) ) {
  // 「確認画面へ」ボタンが押された時の処理

  //バリデーション
  $error = validation( $esc );
  if ( empty( $error ) ) {
    $flag = 1;

    // セッション開始
    session_start();
    $_SESSION[ 'page' ] = true;
  }

} else if ( !empty( $esc[ 'submit' ] ) ) {
  session_start();
  if ( !empty( $_SESSION[ 'page' ] ) && $_SESSION[ 'page' ] === true ) {
    // セッション削除
    unset( $_SESSION[ 'page' ] );

    // 「送信」ボタンが押された時の処理
    $flag = 2;

    // タイムゾーンの設定
    date_default_timezone_set( 'Asia/Tokyo' );

    // 使用言語（日本語）の設定
    mb_language( "ja" );
    mb_internal_encoding( "UTF-8" );

    // 自動返信メール件名
    $reply_subject = "お問い合わせいただきありがとうございます";

    // 自動返信メール本文
    $reply_text = "下記の内容でお問い合わせを受け付けました。" . "\n\n";
    $reply_text .= "お問い合わせ受付日時：" . date( 'Y-m-d H:i' ) . "\n";
    $reply_text .= "お名前：" . $esc[ 'username' ] . "\n";
    $reply_text .= "メールアドレス：" . $esc[ 'email' ] . "\n";
    $reply_text .= "お問い合わせ種別：" . $esc[ 'questions' ] . "\n";
    $reply_text .= "お問い合わせ内容：" . $esc[ 'message' ] . "\n\n";
    $reply_text .= "tomoaki.iki@gmail.com 管理人";

    // 自動返信メールヘッダー情報
    $header = "MIME-Version: 1.0\n";
    $header .= "From: TEST <info@ikis.work>\n";
    $header .= "Reply-To: TEST <tomoaki.iki@gmail.com>\n";

    // 自動返信メールの送信
    mb_send_mail( $esc[ 'email' ], $reply_subject, $reply_text, $header );


    // 管理者通知メールの件名
    $notice_subject = "カルテアプリからメッセージがありました";

    // 管理者通知メールの本文
    $notice_text = "下記の内容でお問い合わせを受け付けました。" . "\n\n";
    $notice_text .= "お問い合わせ受付日時：" . date( 'Y-m-d H:i' ) . "\n";
    $notice_text .= "お名前：" . $esc[ 'username' ] . "\n";
    $notice_text .= "メールアドレス：" . $esc[ 'email' ] . "\n";
    $notice_text .= "お問い合わせ種別：" . $esc[ 'questions' ] . "\n";
    $notice_text .= "お問い合わせ内容：" . $esc[ 'message' ] . "\n";

    // 管理者通知メールの送信
    mb_send_mail( 'tomoaki.iki@gmail.com', $notice_subject, $notice_text, $header );

  } else {
    $flag = 0;
  }
} else {
  $flag = 0;
}


// フラグに応じて表示する画面を切り替え
if ( $flag === 1 ) {
  // 確認画面のHTMLコード
  ?>
<form method="post" action="">
<div class="form_wrap">
  <label>お名前<span>*</span></label>
  <p><?php echo $esc['username'] ?></p>
  <label>メールアドレス<span>*</span></label>
  <p><?php echo $esc['email'] ?></p>
  <label>お問い合わせ種別<span>*</span></label>
  <p><?php echo $esc['questions'] ?></p>
  <label>お問い合わせ内容<span>*</span></label>
  <p><?php echo $esc['message'] ?></p>
</div>
  <input type="submit" name="back" value="戻る" class="hover-transition">
  <input type="submit" name="submit" value="送信" class="hover-transition">
  
  <!-- データを受け渡すために一時的に保存 -->
  <input type="hidden" name="username" value="<?php echo $esc['username'] ?>">
  <input type="hidden" name="email" value="<?php echo $esc['email'] ?>">
  <input type="hidden" name="questions" value="<?php echo $esc['questions'] ?>">
  <input type="hidden" name="message" value="<?php echo $esc['message'] ?>">
</form>
<?php

} else if ( $flag === 2 ) {
  // 送信完了画面のHTMLコード
  ?>
<p class="complete">送信が完了しました。</p>
<p class="complete"><a href="./index.php" class="border_btn ">戻る</a></p>
<?php

} else {
  // お問い合わせフォームのHTMLコード
  if ( !empty( $error ) ) {
    ?>
<ul class="error">
  <?php foreach ($error as $value) { ?>
  <li><?php echo $value; ?></li>
  <?php } ?>
</ul>
<?php
}
?>
<form method="post" action="">
  <div class="form_wrap">
  <label>お名前<span>*</span></label>
  <input type="text" name="username" value="<?php if (!empty($esc['username'])) {
					echo $esc['username'];
				} ?>">
  <label>メールアドレス<span>*</span></label>
  <input type="email" name="email" value="<?php if (!empty($esc['email'])) {
					echo $esc['email'];
				} ?>">
  <label>お問い合わせ種別選択<span>*</span></label>
  <select name="questions">
    <option value="サンプル1" <?php if (!empty($esc['questions']) && $esc['questions'] == 'サンプル1') echo 'selected'; ?>>サンプル1</option>
    <option value="サンプル2" <?php if (!empty($esc['questions']) && $esc['questions'] == 'サンプル2') echo 'selected'; ?>>サンプル2</option>
    <option value="サンプル3" <?php if (!empty($esc['questions']) && $esc['questions'] == 'サンプル3') echo 'selected'; ?>>サンプル3</option>
  </select>
  <label>お問い合わせ内容<span>*</span></label>
  <textarea rows="7" name="message"><?php
  if ( !empty( $esc[ 'message' ] ) ) {
    echo $esc[ 'message' ];
  }
  ?>
</textarea>
</div>
  <input type="submit" name="confirm" value="確認画面へ" class="hover-transition">
</form>
<?php
}
?>


<df-messenger
  intent="WELCOME"
  chat-title="FAQ"
  df-messenger-font-size="2rem"
  chat-title-icon="./img/o.svg"
  agent-id="c47f59c5-4736-4676-bc6e-f28a4b719790"
  language-code="ja"
  chat-icon="./img/o.svg"
>
</df-messenger>

</body>
</html>