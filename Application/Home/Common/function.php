<?php
/**
 * 邮件发送函数
 */
function sendMail($to, $subject, $content) {
    vendor('PHPMailer.class#phpmailer');
    $mail = new PHPMailer();
    // 装配邮件服务器
    if (C('MAIL_SMTP')) {
        $mail->IsSMTP();
    }
    $mail->Host = C('MAIL_HOST');
    $mail->SMTPAuth = C('MAIL_SMTPAUTH');
    $mail->Username = C('MAIL_USERNAME');
    $mail->Password = C('MAIL_PASSWORD');
    $mail->SMTPSecure = C('MAIL_SECURE');
    $mail->CharSet = C('MAIL_CHARSET');
    // 装配邮件头信息
    $mail->From = C('MAIL_USERNAME');
    $mail->AddAddress($to);
    $mail->FromName = 'lym';
    $mail->IsHTML(C('MAIL_ISHTML'));
    // 装配邮件正文信息
    $mail->Subject = $subject;
    $mail->Body = $content;
    // 发送邮件
    if (!$mail->Send()) {
        return FALSE;
    } else {
        return TRUE;
    }
}

function timespan($seconds = 1, $time = '')
    {

        if ( ! is_numeric($seconds))
        {
            $seconds = 1;
        }

        if ( ! is_numeric($time))
        {
            $time = time();
        }

        if ($time <= $seconds)
        {
            $seconds = 1;
        }
        else
        {
            $seconds = $time - $seconds;
        }

        $str = '';
        $years = floor($seconds / 31536000);

        if ($years > 0)
        {
            $str .= $years.' 年, ';
        }

        $seconds -= $years * 31536000;
        $months = floor($seconds / 2628000);

        if ($years > 0 OR $months > 0)
        {
            if ($months > 0)
            {
                $str .= $months.' 月, ';
            }
            $seconds -= $months * 2628000;
        }

        $weeks = floor($seconds / 604800);
        if ($years > 0 OR $months > 0 OR $weeks > 0)
        {
            if ($weeks > 0)
            {
                $str .= $weeks.' 周, ';
            }
            $seconds -= $weeks * 604800;
        }

        $days = floor($seconds / 86400);
        if ($months > 0 OR $weeks > 0 OR $days > 0)
        {
            if ($days > 0)
            {
                $str .= $days.' 天, ';
            }
            $seconds -= $days * 86400;
        }

        $hours = floor($seconds / 3600);
        if ($days > 0 OR $hours > 0)
        {
            if ($hours > 0)
            {
                $str .= $hours.' 小时, ';
            }
            $seconds -= $hours * 3600;
        }
        $minutes = floor($seconds / 60);

        if ($days > 0 OR $hours > 0 OR $minutes > 0)
        {
            if ($minutes > 0)
            {
                $str .= $minutes.' 分钟, ';
            }
            $seconds -= $minutes * 60;
        }
        if ($str == '')
        {
            $str .= $seconds.' 秒, ';
        }
        return substr(trim($str), 0, -1);
    }

?>