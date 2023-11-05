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

const showing_conv_index = ref(-1)
const showing_conv_messages = ref([])

function fetch_messages(conv_id) {
  axios.get(
    '/api/conv/detail.php',
    {
      params: {
        id: conv_id,
      }
    }
  ).then((response) => {
    if (response.data.code == 0) {
      showing_conv_messages.value = response.data.data.messages
    }
  })
}

function switch_conv(conv_id) {
  var conv_index = -1
  for (var i = 0; i < conversations.value.length; i++) {
    if (conversations.value[i].id == conv_id) {
      conv_index = i
      break
    }
  }
  showing_conv_index.value = conv_index
  fetch_messages(conversations.value[conv_index].id)
}

function new_conv() {
  showing_conv_index.value = -1
  showing_conv_messages.value = []
}

window.onload = function () {
  fetch_conversation_list()
}

const asking = ref(false)

function ask(){
  asking.value = true
}

</script>

<template>
  <div id="overall_container">
    <div id="conv_list_panel">
      <div id="site_title">ChatPHP by RockChinQ</div>
      <div id="conv_list">
        <div class="conv_item" v-for="conv in conversations"
          :style="{ borderLeftColor: showing_conv_index != -1 && conv.id == conversations[showing_conv_index].id ? '#F7A072' : '#fff' }"
          :key="conv.id" @click="switch_conv(conv.id)">
          <div class="conv_item_title">
            {{ conv.title }}
          </div>
          <div class="conv_item_brief">
            {{ conv.brief }}
          </div>
        </div>
      </div>
      <div id="conv_operation_panel">
        <button id="create_conv" class="op_btn" @click="new_conv">New</button>
      </div>
    </div>
    <div id="chat_panel">
      <div id="messages_panel">
        <div id="hint_to_chat" v-if="showing_conv_index == -1">
          Please select a conversation or send a new message to start a new conversation.
        </div>
        <div id="messages_flow" v-if="showing_conv_index != -1">
          <div class="message_item" v-for="message in showing_conv_messages">
            <img class="role_avatar"
              :src="message.role == 'user' ? 'https://seed-jianbei-public.oss-cn-hangzhou.aliyuncs.com/mytan/10077/AVATAR/d306b5de-5767-4872-8b59-3566f6e4b061.jpg' : 'https://mytan.maiseed.com.cn/assets/tan-avatar.png'">
            <div class="message_content">
              {{ message.content }}
            </div>
          </div>
        </div>
      </div>
      <div id="input_panel">
        <textarea id="input_area"></textarea>
        <el-button id="send" v-loading="asking"  element-loading-svg-view-box="-25, -25, 100, 100"  @click="ask">Send</el-button>
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
  background-color: #000;
}

#conv_list_panel{
  position: relative;
  width: 25%;
  left: 2%;
  top: 2%;
  height: 96%;
  /* background-color: #f0f0f0; */
  display: flex;
  flex-direction: column;
  background-color: rgb(37, 35, 74);
  /* box-shadow: 3px 3px 30px rgb(28, 32, 102); */
  border-radius: 2rem 0 0 2rem;
  z-index: 100;
}

#site_title {
  position: relative;
  width: 100%;
  height: 6rem;
  /* background-color: #fff; */
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 1.5rem;
  color: #fff;
  /* border-bottom: solid 1px #f0f0f0; */
  border-bottom: solid 1px #3D405B;
}

#conv_list {
  position: relative;
  width: 100%;
  height: calc(100% - 6rem - 6rem);
  top: 0;
  left: 0;
  /* background-color: #f0f0f0; */
  overflow-y: auto;
  display: block;
  flex-direction: column;
  align-items: start;
}

#conv_operation_panel {
  position: absolute;
  width: calc(80% - 40px);
  left: 1.6rem;
  bottom: 1.7rem;
  /* background-color: #fff; */
  display: flex;
  flex-direction: row;
  justify-content: flex-start;
  align-items: center;
}

.op_btn {
  background-color: #ea8b59;
  color: #ffffff;
  /* border: solid 1px #ffffff; */
  border: 0;
  border-radius: 5px;
  align-items: center;
  height: 2rem;
  padding-inline: 1rem;
  /* font-size: ; */
  font-weight: 600;
}

.op_btn:active {
  background-color: rgb(218, 121, 42);
}

.conv_item {
  position: relative;
  width: calc(100% - 3.6rem);
  /* top: 0.4rem; */
  box-shadow: 1px 1px 3px rgb(0, 0, 0, 0.3);
  margin-top: 0.6rem;
  height: 4rem;
  left: 1.6rem;
  background-color: rgb(0, 3, 19);
  border-radius: 5px;
  border-left-color: #ffffff;
  /* border-left-color: #F7A072; */
  border-left-width: 0.3rem;
  border-left-style: solid;
  user-select: none;
  display: flex;
}

.conv_item_title {
  position: absolute;
  top: 0.5rem;
  left: 0.8rem;
  font-size: 1.2rem;
  color: #fff;
  width: calc(100% - 60px);
  white-space: nowrap;
}

.conv_item_brief {
  position: absolute;
  top: 2.4rem;
  left: 0.8rem;
  font-size: 0.8rem;
  color: #a7a7a7;
  width: calc(100% - 30px);
  white-space: nowrap;
}

#chat_panel {
  position: relative;
  width: 71%;
  height: 96%;
  top: 2%;
  left: 2%;
  /* background-color: #f0f0f0; */
  display: flex;
  flex-direction: column;
  background-color: rgb(23, 23, 37);
  border-radius: 0 2rem 2rem 0;
}

#messages_panel {
  position: relative;
  width: 100%;
  height: calc(100% - 6rem);
  /* background-color: #fff; */
}

#input_panel {
  position: relative;
  width: 100%;
  height: 6rem;
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  border-top-width: 1px;
  border-top-style: solid;
  border-top-color: #3D405B;
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

#hint_to_chat {
  position: relative;
  width: 100%;
  height: 100%;
  color: #fff;
  font-size: 1.2rem;
  display: flex;
  justify-content: center;
  align-items: center;
  user-select: none;
}

#messages_flow {
  position: relative;
  width: calc(100%);
  height: calc(100% - 1.7rem);
  left: 0rem;
  top: 1.2rem;
  overflow-y: auto;
  /* background-color: #F7A072; */
  display: flex;
  flex-direction: column;
  align-items: center;
  /* z-index: 100000; */
  /* padding-bottom: 10rem; */
  /* scrollbar-width: none; */
  /* scrollbar-color: dark; */
}

.message_item {
  display: flex;
  margin-bottom: 1.4rem;
  width: 60%;
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
  width: calc(100% - 5rem);
  height: auto;
  padding-top: 0.8rem;
  left: 0.4rem;
  color: #fff;
  /* background-color: #a7a7a7; */
}
</style>
