<?php
/**
 * Helper Functions
 * Student Education System
 */

if (!function_exists('sanitize')) {
    function sanitize(mixed $data): string {
        if (is_null($data)) return '';
        return htmlspecialchars(trim((string)$data), ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('formatCurrency')) {
    function formatCurrency(float|int|string $amount): string {
        $num = (float)$amount;
        if ($num <= 0) return 'Free / Grant';
        return CURRENCY_SYMBOL . number_format($num, 0, '.', ',');
    }
}

if (!function_exists('renderRatingStars')) {
    function renderRatingStars(float|int $rating): string {
        $rating = round((float)$rating, 1);
        $fullStars = floor($rating);
        $hasHalf = ($rating - $fullStars) >= 0.4;
        $html = '<div class="star-rating" title="' . $rating . ' out of 5 stars">';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $fullStars) {
                $html .= '<i class="fas fa-star filled"></i>';
            } elseif ($hasHalf && $i == $fullStars + 1) {
                $html .= '<i class="fas fa-star-half-alt filled"></i>';
            } else {
                $html .= '<i class="far fa-star"></i>';
            }
        }
        $html .= '<span class="rating-value">' . number_format($rating, 1) . '</span></div>';
        return $html;
    }
}

if (!function_exists('renderBadge')) {
    function renderBadge(string $type, string $text): string {
        $typeClass = match(strtolower($type)) {
            'university' => 'badge-primary',
            'college' => 'badge-info',
            'school' => 'badge-success',
            'undergraduate' => 'badge-blue',
            'postgraduate' => 'badge-purple',
            'diploma' => 'badge-amber',
            'doctorate' => 'badge-rose',
            'pending' => 'badge-warning',
            'contacted' => 'badge-info',
            'enrolled' => 'badge-success',
            'under review' => 'badge-secondary',
            default => 'badge-default'
        };
        return '<span class="badge ' . $typeClass . '">' . sanitize($text) . '</span>';
    }
}

if (!function_exists('timeAgo')) {
    function timeAgo(string $datetime): string {
        $time = strtotime($datetime);
        $diff = time() - $time;
        if ($diff < 60) return 'Just now';
        if ($diff < 3600) return floor($diff / 60) . ' mins ago';
        if ($diff < 86400) return floor($diff / 3600) . ' hours ago';
        if ($diff < 604800) return floor($diff / 86400) . ' days ago';
        return date('M d, Y', $time);
    }
}

if (!function_exists('getFacilitiesArray')) {
    function getFacilitiesArray(?string $facilities): array {
        if (empty($facilities)) return [];
        return array_map('trim', explode(',', $facilities));
    }
}

if (!function_exists('activeNav')) {
    function activeNav(string $page): string {
        $currentPage = basename($_SERVER['PHP_SELF'] ?? '');
        return ($currentPage === $page) ? 'active' : '';
    }
}

if (!function_exists('setFlash')) {
    function setFlash(string $type, string $message): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }
}

if (!function_exists('getFlash')) {
    function getFlash(): ?array {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }
}
