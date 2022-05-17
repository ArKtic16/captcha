<?php

class Captcha
{
    const WIDTH = 110;
    const HEIGHT = 60;
    const FONTSIZE = 16;
    const SIZE = 4;
    const BG_SIZE = 50;
    const FONT = 'w:\domains\test\fonts\times.ttf'; // change to use!!!


    private static $letters = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'm', 'n', 'p', 'q', 'r', 's',
        't', 'u', 'v', 'w', 'x', 'y', 'z', 1, 2, 3, 4, 5, 6, 7, 8, 9];
    private static $colors = [10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120, 130, 140, 150, 160, 170, 180, 190,
        200, 210, 220, 230, 240, 250];

    public static function generate()
    {
        session_start();
        $im = imagecreatetruecolor(self::WIDTH, self::HEIGHT);
        imagefill($im, 1, 1, imagecolorallocate($im, 255, 255, 255));
        for ($i = 0; $i < self::BG_SIZE; $i++) {
            imagettftext($im, mt_rand(self::FONTSIZE - 2, self::FONTSIZE + 2), mt_rand(-90, 90),
                mt_rand(0, self::WIDTH), mt_rand(0, self::HEIGHT),
                imagecolorallocatealpha($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255), 100),
                self::FONT, self::$letters[mt_rand(0, count(self::$letters) -1)]);
        }
        $code = '';
        for ($i = 0; $i < self::SIZE; $i++) {
            $x = ($i + 1) * self::FONTSIZE + mt_rand(0, 5);
            $y = self::HEIGHT * 2 / 3 + mt_rand(0, 5);
            $color = imagecolorallocatealpha($im, mt_rand(0, self::$colors[mt_rand(0, count(self::$colors) - 1)]),
                self::$colors[mt_rand(0, count(self::$colors) - 1)],
                self::$colors[mt_rand(0, count(self::$colors) - 1)], mt_rand(10, 30));
            $letter = self::$letters[mt_rand(0, count(self::$letters) -1)];
            imagettftext($im, mt_rand(self::FONTSIZE * 2 - 2, self::FONTSIZE * 2 + 2), mt_rand(-10, 10), $x, $y,
                $color, self::FONT, $letter);
            $code .= $letter;
        }
        $_SESSION['code'] = $code;

        header('Content-type: image/jpeg');
        imagejpeg($im);
        imagedestroy($im);
    }

    public static function check($code)
    {
        if(!session_id()) session_start();
        return $code === $_SESSION['code'];
    }
}

