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
        'answer_question' => 15, // 回答问题,15积分/问题
        'answer_question_max' => 30, // 回答问题,每节课提问问题可获得积分上限：30积分
        'rank_level' => 100, // 晋升一个阶段将获得100积分
    ],

    // 视频记录心跳时间
    'video_heartbeat_times' => 16, //秒数
    // 学习时长等级限制
    'study_level' => [
        'course_duration' => 600, //每节课学习时长等级标准(秒数)10min
        'course_public_min' => 20, //报名后学完指定20节公开课
    ],

];
