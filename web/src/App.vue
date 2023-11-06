<script setup>
import { ref } from 'vue'

import axios from 'axios'

const conversations = ref([])

// function unescape(raw) {
//   raw = raw.replace()
// }

function fetch_conversation_list(then = null) {
  axios.get(
    '/api/conv/list.php',
  ).then((response) => {
    if (response.data.code == 0) {
      for (var i = 0; i < response.data.data.length; i++) {
        response.data.data[i].messages = JSON.parse(response.data.data[i].messages)

        if (response.data.data[i].messages.length > 0) {
          response.data.data[i].brief = response.data.data[i].messages[response.data.data[i].messages.length - 1].content
        } else {
          response.data.data[i].brief = '无内容'
        }
      }
      conversations.value = response.data.data
      if (then != null) {
        then()
      }
    }
  })
}

const showing_conv_index = ref(-1)
const showing_conv_messages = ref([])

function fetch_messages(conv_id, then = null) {
  axios.get(
    '/api/conv/detail.php',
    {
      params: {
        id: conv_id,
      }
    }
  ).then((response) => {
    if (response.data.code == 0) {
      response.data.data.messages = JSON.parse(response.data.data.messages)
      showing_conv_messages.value = response.data.data.messages
      if (then != null) {
        then()
      }
    }
  })
}

function switch_conv(conv_id, then = null) {
  var conv_index = -1
  for (var i = 0; i < conversations.value.length; i++) {
    if (conversations.value[i].id == conv_id) {
      conv_index = i
      break
    }
  }
  showing_conv_index.value = conv_index
  fetch_messages(conversations.value[conv_index].id, then)
}

function chat_completion() {
  asking.value = true
  axios.post(
    '/api/llm/gpt.php',
    {
      model: "gpt-3.5-turbo",
      messages: JSON.stringify(showing_conv_messages.value),
    }, {
    headers: {
      'Content-Type': 'multipart/form-data'
    }
  }
  ).then((response) => {
    console.log(response)
    if (response.data.code == 0) {
      console.log(response.data.data)

      var temp = showing_conv_messages.value

      temp.push({
        role: 'assistant',
        content: response.data.data.choices[0].message.content,
      })

      showing_conv_messages.value = temp

      sync_messages()
    } else {
      console.log(response.data.msg)
    }
  }).catch((error) => {
    console.log(error)
  }).finally(() => {
    asking.value = false
  })
}

function sync_messages() {
  var id = conversations.value[showing_conv_index.value].id
  var messages = showing_conv_messages.value

  // 拷贝
  messages = JSON.parse(JSON.stringify(messages))

  // 挨个转义
  for (var i = 0; i < messages.length; i++) {
    messages[i].content = messages[i].content.replace(/"/g, '\\"')
    messages[i].content = messages[i].content.replace(/'/g, "\\'")
    messages[i].content = messages[i].content.replace(/\n/g, '\\n')
    messages[i].content = messages[i].content.replace(/\r/g, '\\r')
    messages[i].content = messages[i].content.replace(/\t/g, '\\t')
  }

  messages = JSON.stringify(messages)

  axios.post(
    '/api/conv/sync.php',
    {
      id: id,
      title: conversations.value[showing_conv_index.value].title,
      messages: messages,
    },
    {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    }
  ).then((response) => {
    if (response.data.code == 0) {
      console.log('sync success')
    } else {
      console.log(response.data.msg)
    }
  })
}

function new_conv() {
  showing_conv_index.value = -1
  showing_conv_messages.value = []
}

function del_conv(conv_id){
  axios.post(
    '/api/conv/delete.php',
    {
      id: conv_id,
    },
    {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    }
  ).then((response) => {
    if (response.data.code == 0) {
      fetch_conversation_list()

      showing_conv_index.value = -1
      showing_conv_messages.value = []
    } else {
      console.log(response.data.msg)
    }
  })
}

window.onload = function () {
  fetch_conversation_list()
}

const asking = ref(false)

function ask() {
  if (document.getElementById('input_area').value == '') {
    alert('请输入内容')
    return
  }

  var user_message = {
    role: 'user',
    content: document.getElementById('input_area').value,
  }

  document.getElementById('input_area').value = ''

  // create 
  if (showing_conv_index.value == -1) {
    axios.post(
      '/api/conv/create.php',
      {
        title: user_message.content,
      },
      {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }
    ).then((response) => {
      if (response.data.code == 0) {

        fetch_conversation_list(
          () => {
            switch_conv(response.data.data.id,
              () => {
                var temp = showing_conv_messages.value
                temp.push(user_message)
                showing_conv_messages.value = temp

                for (var i = 0; i < conversations.value.length; i++) {
                  if (conversations.value[i].id == response.data.data.id) {
                    showing_conv_index.value = i

                    chat_completion()
                    break
                  }
                }
              }
            )
          }
        )

      } else {
        alert(response.data.msg)
      }
    })
    return
  } else {
    var temp = showing_conv_messages.value
    temp.push(user_message)
    showing_conv_messages.value = temp

    chat_completion()
  }
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
          <div class="conv_item_del" @click="del_conv(conv.id)">
            X
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
              <pre class="message_content_inter">{{ message.content }}</pre>
            </div>
          </div>
        </div>
      </div>
      <div id="input_panel">
        <textarea id="input_area"></textarea>
        <el-button id="send" v-loading="asking" element-loading-svg-view-box="-25, -25, 100, 100"
          @click="ask">Send</el-button>
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

#conv_list_panel {
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
  box-shadow: 1px 1px 3px rgba(23, 23, 23, 0.8);
  top: 0.8rem;
  margin-top: 1rem;
  height: 5rem;
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
  top: 0.7rem;
  left: 0.8rem;
  font-size: 1.3rem;
  color: #fff;
  width: calc(100% - 60px);
  white-space: nowrap;
}

.conv_item_brief {
  position: absolute;
  top: 2.9rem;
  left: 0.8rem;
  font-size: 1rem;
  color: #a7a7a7;
  width: calc(100% - 4rem);
  white-space: nowrap;
  overflow: hidden;
}

.conv_item_del {
  position: absolute;
  top: 1.2rem;
  right: 1.2rem;
  font-size: 1.5rem;
  color: #fff;
  width: 1.5rem;
  height: 1.5rem;
  display: flex;
  justify-content: center;
  align-items: center;
  /* border-radius: 50%; */
  background-color: #ea8b59;
  cursor: pointer;
}

.conv_item_del:hover {
  background-color: rgb(218, 121, 42);
}

.conv_item_del:active {
  background-color: rgb(189, 90, 9);
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
  top: -0.4rem;
  left: 0.5rem;
  color: #fff;
  font-size: 1.2rem;
  /* background-color: #a7a7a7; */
}

.message_content_inter {
  white-space: pre-wrap;
  word-wrap: break-word;
}
</style>
