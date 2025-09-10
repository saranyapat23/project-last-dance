<?php
require_once '../../includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table_id = $_POST['table_id'] ?? null;
    $status   = $_POST['status'] ?? null;
    $time     = date('Y-m-d H:i:s');

    if ($table_id && in_array($status, ['OPEN', 'CLOSED'])) {

        if ($status === 'OPEN') {
            // เปิดโต๊ะ → สร้าง order ใหม่
            $stmt = $pdo->prepare("INSERT INTO orders (table_id, status, order_at) VALUES (?, 'pending', ?)");
            $stmt->execute([$table_id, $time]);
            $order_id = $pdo->lastInsertId();

            // อัปเดตโต๊ะให้จำ order ปัจจุบัน
            $stmt = $pdo->prepare("UPDATE tables SET status = 'OPEN', update_at = ?, current_order_id = ? WHERE table_id = ?");
            $stmt->execute([$time, $order_id, $table_id]);

        } elseif ($status === 'CLOSED') {
            // ปิดโต๊ะ → ปิด order ปัจจุบัน
            $stmt = $pdo->prepare("SELECT current_order_id FROM tables WHERE table_id = ?");
            $stmt->execute([$table_id]);
            $order_id = $stmt->fetchColumn();

            if ($order_id) {
                $stmt = $pdo->prepare("UPDATE orders SET status = 'completed', updated_at = ? WHERE id = ?");
                $stmt->execute([$time, $order_id]);
            }

            // ปิดโต๊ะ + เคลียร์ current_order_id
            $stmt = $pdo->prepare("UPDATE tables SET status = 'CLOSED', update_at = ?, current_order_id = NULL WHERE table_id = ?");
            $stmt->execute([$time, $table_id]);
        }

        echo "success";
    } else {
        echo "invalid";
    }
}
