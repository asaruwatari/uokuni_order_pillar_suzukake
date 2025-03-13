<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = [
    // 管理者
    'admin'  => [
        // <editor-fold defaultstate="collapsed" desc="validation_rules">
        [
            'field' => 'id',
            'label' => 'ID',
        ],
        [
            'field' => 'admin_type_id',
            'label' => '区分',
            'rules' => 'required|is_natural'
        ],
        [
            'field' => 'code',
            'label' => 'ログインID',
            'rules' => 'required|alpha_numeric|min_length[4]|max_length[32]|is_unique[admin.code]'
        ],
        [
            'field'   => 'password',
            'label'   => 'パスワード',
            'rules'   => 'required|password',
            'guide'   => '半角英数字を含む8文字以上32文字以下',
            'comment' => '新規：必須　編集：任意（入力で変更）',
        ],
        [
            'field' => 'name',
            'label' => '氏名',
            'rules' => 'required|max_length[20]'
        ],
        [
            'field' => 'deleted_flag',
            'label' => '無効',
            'rules' => 'is_natural|less_than_equal_to[1]'
        ],
        [
            'field' => 'created_at',
            'label' => '作成日時',
        ],
        [
            'field' => 'updated_at',
            'label' => '更新日時',
        ],
    // </editor-fold>
    ],
    // 商品
    'item'   => [
        // <editor-fold defaultstate="collapsed" desc="validation_rules">
        [
            'field' => 'id',
            'label' => 'ID',
            'rules' => 'is_natural'
        ],
        [
            'field' => 'date',
            'label' => '日付',
            'rules' => 'required|date',
        ],
        [
            'field' => 'item_type_id',
            'label' => '区分',
            'rules' => 'required|is_natural'
        ],
        [
            'field' => 'name',
            'label' => '名称',
            'rules' => 'max_length[30]',
        ],
//        [
//            'field' => 'price',
//            'label' => '金額',
//            'rules' => 'is_natural|less_than_equal_to[99999]',
//            'unit'  => '円',
//        ],
//        [
//            'field' => 'qty',
//            'label' => '上限数',
//            'rules' => 'is_natural|less_than_equal_to[99999]',
//            'unit'  => '食',
//        ],
//        [
//            'field' => 'order_deadline_day',
//            'label' => '注文締切日',
//            'rules' => 'less_than_equal_to[30]',
//            'unit'  => '日前',
//        ],
//        [
//            'field' => 'order_deadline_time',
//            'label' => '注文締切時間',
//            'rules' => 'minutestime',
//            'guide' => 'HH:MM',
//        ],
    // </editor-fold>
    ],
    // 注文
    'order'  => [
        // <editor-fold defaultstate="collapsed" desc="validation_rules">
        [
            'field' => 'id',
            'label' => 'ID',
            'rules' => 'is_natural'
        ],
        [
            'field' => 'user_id',
            'label' => '利用者',
            'rules' => 'required|is_natural'
        ],
        [
            'field' => 'date',
            'label' => '日付',
            'rules' => 'required|date',
        ],
        [
            'field' => 'item_id',
            'label' => 'メニュー',
            'rules' => 'required|is_natural'
        ],
//        [
//            'field' => 'delivery_id',
//            'label' => '配達先',
//            'rules' => 'required|is_natural'
//        ],
        [
            'field' => 'ip',
            'label' => '注文IP',
            'rules' => 'max_length[20]',
            'guide' => '',
        ],
//        [
//            'field' => 'received_at',
//            'label' => '受取日時',
//            'rules' => 'date',
//            'guide' => '',
//        ],
//        [
//            'field' => 'received_ip',
//            'label' => '受取IP',
//            'rules' => 'max_length[20]',
//            'guide' => '',
//        ],
        [
            'field' => 'canceled_flag',
            'label' => 'キャンセル',
            'rules' => 'is_natural|less_than_equal_to[1]',
        ],
        [
            'field' => 'remarks',
            'label' => '備考',
            'rules' => 'max_length[100]',
            'guide' => '100文字まで',
        ],
    // </editor-fold>
    ],
    // 利用者
    'user'   => [
        // <editor-fold defaultstate="collapsed" desc="validation_rules">
        [
            'field' => 'id',
            'label' => 'ID',
        ],
        [
            'field' => 'user_type_id',
            'label' => '区分',
            'rules' => 'required|is_natural'
        ],
        [
            'field' => 'code',
            'label' => '職番',
            'rules' => 'required|alpha_numeric|min_length[4]|max_length[32]|is_unique[user.code]'
        ],
        [
            'field'   => 'password',
            'label'   => 'パスワード',
            'rules'   => 'required|password',
            'guide'   => '半角英数字を含む8文字以上32文字以下',
            'comment' => '新規：必須　編集：任意（入力で変更）',
        ],
        [
            'field' => 'name',
            'label' => '氏名',
            'rules' => 'required|max_length[20]'
        ],
        [
            'field' => 'deleted_flag',
            'label' => '無効',
            'rules' => 'is_natural|less_than_equal_to[1]'
        ],
        [
            'field' => 'created_at',
            'label' => '作成日時',
        ],
        [
            'field' => 'updated_at',
            'label' => '更新日時',
        ],
    // </editor-fold>
    ],
    // システム設定
    'system' => [
        // <editor-fold defaultstate="collapsed" desc="validation_rules">
        [
            'field' => 'id',
            'label' => 'ID',
        ],
        [
            'field' => 'price',
            'label' => '食単価',
            'rules' => 'required|is_natural|less_than_equal_to[9999]',
            'unit'  => '円',
        ],
        [
            'field' => 'deadline_day',
            'label' => '締め切り日',
            'rules' => 'required|is_natural|less_than_equal_to[30]',
            'unit'  => '日前',
        ],
        [
            'field' => 'deadline_hour',
            'label' => '締め切り時間',
            'rules' => 'required|time',
        ],
        [
            'field' => 'created_at',
            'label' => '作成日時',
        ],
        [
            'field' => 'updated_at',
            'label' => '更新日時',
        ],
    // </editor-fold>
    ],
];
