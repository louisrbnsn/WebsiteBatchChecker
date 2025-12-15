<?php
class WebsiteStatus {
    const UP = 'UP';
    const DOWN = 'DOWN';
    
    public static function getBadgeClass($status) {
        return $status === self::UP ? 'bg-success' : 'bg-danger';
    }
}