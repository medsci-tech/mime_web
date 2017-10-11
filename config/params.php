<?php

return [
    // 状态
    'status_option' => [
        1 => '显示',
        0 => '不显示',
    ],

    // 消息类型
    'msg_type_option' => [
        1 => '平台消息',
        2 => '站点消息',
        3 => '个人消息',
    ],

    // 职称
    'doctor_title' => [
        '住院医师',
        '主治医师',
        '副主任医师',
        '主任医师',
    ],

    // 医院等级
    'hospital_level' => [
        '基层医疗机构',
        '一级',
        '二级',
        '三级',
    ],

    // 选修课/必修课
    'curse_type' => [
        1 => '必修',
        2 => '选修',
    ],

    // 迈豆规则
    'bean_rules' => [
        'watch_video' => 15, // 观看视频
        'required_course' => 80, // 必修课每期课件学习时长≥ 10分钟
        'answer_course' => 30, // 答疑课每期课件学习时长≥ 10分钟
        'apply_course' => 100, // 私教课申请
        'click_course' => 1, // 视频1积分/点击次数,每节课点击可获得积分上限：4积分 ,即单节课最多加4次
        'ask_question' => 10, // 提问问题,10积分/问题
        'ask_question_max' => 20, // 提问问题,每节课提问问题可获得积分上限：20积分
        'answer_question' => 15, // 回答问题,15积分/问题
        'rank_level' => 100, // 晋升一个阶段将获得100积分
        'recommend_credit' => 100, // 推荐一个人获得100积分
    ],

    // 视频记录心跳时间
    'video_heartbeat_times' => 16, //秒数
    // 学习时长等级限制
    'study_level' => [
        'course_duration' => 600, //每节课学习时长等级标准(秒数)10min
        'course_public_min' => 20, //报名后学完指定20节公开课
    ],

    // 空中课堂课程单元
    'kzkt_class_unit' => [
        1 => '糖尿病基础知识',
        2 => '糖尿病的药物治疗',
        3 => '糖尿病管理',
        4 => '糖尿病并发症管理',
        5 => '特殊类型/人群糖尿病',
        6 => '其他内分泌疾病',
    ],

    // 私教课状态
    'private_class_status_option' => [
        0 => '已报名',
        1 => '已审核',
        -1 => '未通过',
        -2 => '已取消',
    ],

    // 私教课期数
    'private_class_term' => 1,
    // 私教课名额
    'private_class_count' => 26,

    //学员晋升A：学习时长
    'up_to_second'=>180,//学习总时长累计180分钟达到二级学员
    'up_to_third'=>190,//选修课累计达到190分钟成为3级学员
    //学员晋升B：随机出题数量
    'question_num' => 10,

];
