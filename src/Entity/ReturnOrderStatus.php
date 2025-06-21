<?php

namespace App\Entity;

enum ReturnOrderStatus: string
{
    case REQUESTED = 'requested';     // Khách hàng đã yêu cầu trả hàng
    case APPROVED = 'approved';       // Yêu cầu trả hàng đã được duyệt
    case REJECTED = 'rejected';       // Yêu cầu trả hàng bị từ chối
    case RETURNED = 'returned';       // Hàng đã được trả về
    case REFUNDED = 'refunded';       // Đã hoàn tiền
}
