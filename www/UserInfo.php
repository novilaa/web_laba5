<?php
class UserInfo {
    public static function getInfo(): array {
        return [
            'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'time' => date('Y-m-d H:i:s')
        ];
    }

    public static function saveToCookie(array $data): void {
        setcookie("user_info", json_encode($data), time() + (86400 * 30), "/");
    }

    public static function getFromCookie(): array {
        if (isset($_COOKIE['user_info'])) {
            return json_decode($_COOKIE['user_info'], true) ?? [];
        }
        return [];
    }
}
?>