<script setup>
import { ref } from 'vue'

import axios from 'axios'

const conversations = ref([])

function fetch_conversation_list() {
  axios.get(
    '/api/conv/list.php',
  ).then((response) => {
    if (response.data.code == 0) {
      conversations.value = response.data.data
    }
  })
}

const showing_conv_index = ref(0)
const showing_conv_messages = ref([
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
    "content": "我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。"
  },
  {
    "role": "user",
    "content": "你是谁？"
  },
  {
    "role": "assistant",
    "content": "我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。"
  },
  {
    "role": "user",
    "content": "你是谁？"
  },
  {
    "role": "assistant",
    "content": "我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。"
  },
  {
    "role": "user",
    "content": "你是谁？"
  },
  {
    "role": "assistant",
    "content": "我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。"
  },
  {
    "role": "user",
    "content": "你是谁？"
  },
  {
    "role": "assistant",
    "content": "我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。我是助手，你可以问我任何问题。"
  }
])

function fetch_messages(conv_id) {
}

window.onload = function () {
  fetch_conversation_list()
}

</script>

<template>
  <div id="overall_container">
    <div id="conv_list">
      <div class="conv_item" v-for="conv in conversations"
        :style="{ borderLeftColor: showing_conv_index != -1 && conv.id == conversations[showing_conv_index].id ? '#F7A072' : '#fff' }"
        :key="conv.id">
        <div class="conv_item_title">
          {{ conv.title }}
        </div>
        <div class="conv_item_brief">
          {{ conv.brief }}
        </div>
      </div>
    </div>
    <div id="chat_panel">
      <div id="messages_panel">
        <div id="hint_to_chat" v-if="showing_conv_index == -1">
          Please select a conversation to chat.
        </div>
        <div id="messages_flow" v-if="showing_conv_index != -1">
          <div class="message_item" v-for="message in showing_conv_messages">
            <img class="role_avatar" :src="message.role=='user'?'https://seed-jianbei-public.oss-cn-hangzhou.aliyuncs.com/mytan/10077/AVATAR/d306b5de-5767-4872-8b59-3566f6e4b061.jpg':'https://mytan.maiseed.com.cn/assets/tan-avatar.png'">
            <div class="message_content">
              {{ message.content }}
            </div>
          </div>
        </div>
      </div>
      <div id="input_panel">
        <textarea id="input_area"></textarea>
        <el-button id="send">Send</el-button>
      </div>
    </div>
  </div>
</template>

<style scoped>
#overall_container {
  position: absolute;
  top: 0;
  left: 0;
  display: flex;
  flex-direction: row;
  width: 100%;
  height: 100%;
  background-color: rgb(37, 35, 74);
}

#conv_list {
  position: relative;
  width: 25%;
  height: 100%;
  /* background-color: #f0f0f0; */
  display: flex;
  flex-direction: column;
  overflow: scroll;
}

.conv_item {
  position: relative;
  width: calc(80% - 40px);
  margin-top: 0.8rem;
  top: 0.3rem;
  left: 1rem;
  height: 4rem;
  background-color: rgb(0, 3, 19);
  border-radius: 5px;
  border-left-color: #ffffff;
  /* border-left-color: #F7A072; */
  border-left-width: 0.3rem;
  border-left-style: solid;
  user-select: none;
}

.conv_item_title {
  position: relative;
  top: 22px;
  transform: translateY(-50%);
  left: 10px;
  font-size: 1.2rem;
  color: #fff;
  width: calc(100% - 60px);
  white-space: nowrap;
}

.conv_item_brief {
  position: relative;
  top: 20px;
  transform: translateY(-50%);
  left: 10px;
  font-size: 0.8rem;
  color: #a7a7a7;
  width: calc(100% - 30px);
  white-space: nowrap;
}

#chat_panel {
  position: relative;
  width: 75%;
  height: 100%;
  /* background-color: #f0f0f0; */
  display: flex;
  flex-direction: column;
}

#messages_panel {
  position: relative;
  width: 100%;
  height: calc(100% - 6rem);
  /* background-color: #fff; */
  overflow: scroll;
}

#input_panel {
  position: relative;
  width: 80%;
  height: 6rem;
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  /* background-color: #dc6060; */
}

#input_area {
  position: relative;
  width: 50%;
  height: calc(100% - 3.8rem);
  /* top: 0.9rem; */
  background-color: #3D405B;
  border-radius: 5px;
  /* border: solid 3px #111; */
  border: 0;
  color: #fff;
}

#send {
  background-color: #7E5A83;
  border: inset(solid 1px #fff);
  color: #fff;
  margin-left: 10px;
}

#send:active {
  background-color: #573e5a;
  border: 0;
  color: #fff;
}

#messages_flow {
  position: relative;
  width: 100%;
  height: 100%;
}

.message_item {
  display: flex;
  margin-top: 1rem;
  width: 90%;
  /* background-color: aqua; */
}

.role_avatar {
  position: relative;
  width: 2rem;
  height: 2rem;
  border-radius: 5px;
  margin-top: 0.5rem;
  margin-left: 0.5rem;
  margin-right: 0.5rem;
}

.message_content {
  position: relative;
  width: calc(100% - 3rem);
  height: auto;
  padding-top: 0.8rem;
  color: #fff;
}
</style>
