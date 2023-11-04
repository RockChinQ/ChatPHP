import Mock from 'mockjs'

Mock.mock('/api/conv/list.php', 'get', {
    'code': 0,
    'msg': 'ok',
    'data': [
        {
            "id": 1,
            "time": "2019-01-01 12:00:00",
            "title": "标题1",
            "brief": "回复内容1",
        },
        {
            "id": 2,
            "time": "2019-01-01 12:00:00",
            "title": "标题2",
            "brief": "回复内容2",
        },
        {
            "id": 3,
            "time": "2019-01-01 12:00:00",
            "title": "标题3",
            "brief": "回复内容2",
        }
    ]
})

// api/conv/detail.php?id=1
Mock.mock(/\/api\/conv\/detail.php/, 'get', {
    'code': 0,
    'msg': 'ok',
    'data': {
        "id": 1,
        "time": "2019-01-01 12:00:00",
        "title": "标题1",
        "messages": [
            {
                "role": "user",
                "content": "你好",
            },
            {
                "role": "assistant",
                "content": "你好，有什么可以帮助你的吗？",
            },
            {
                "role": "user",
                "content": "你是谁？"
            },
            {
                "role": "assistant",
                "content": "我是助手，你可以问我任何问题。"
            },
            {
                "role": "user",
                "content": "你是谁？"
            },
            {
                "role": "assistant",
                "content": "我是助手，你可以问我任何问题。"
            },
            {
                "role": "user",
                "content": "你是谁？"
            },
            {
                "role": "assistant",
                "content": "我是助手，你可以问我任何问题。"
            },
            {
                "role": "user",
                "content": "你是谁？"
            },
            {
                "role": "assistant",
                "content": "我是助手，你可以问我任何问题。"
            },
            {
                "role": "user",
                "content": "你是谁？"
            },
            {
                "role": "assistant",
                "content": "我是助手，你可以问我任何问题。"
            },
            {
                "role": "user",
                "content": "你是谁？"
            },
            {
                "role": "assistant",
                "content": "我是助手，你可以问我任何问题。"
            },
            {
                "role": "user",
                "content": "你是谁？"
            },
            {
                "role": "assistant",
                "content": "我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。"
            }
        ],
    }
})