<template>
  <div>
    <div :class="[boxChatPosition, 'area-chat']" :style="boxChatMargin">
      <div v-if="boxChatIsShow" class="box-chat">
        <div class="box-title">
          <div class="avatar">
            <!-- <img width="100%" :src="chatPerson?.user_avatar" /> -->
            <span>{{ chatPerson?.user_avatar.substring(0,1) }}</span>
          </div>
          <div class="name">
            <strong>{{ chatPerson?.user_name }}</strong>
          </div>
          <div class="icon">
            <font-awesome-icon
              icon="fa-solid fa-window-restore"
              size="lg"
              @click="hideBoxChat()"
            />
            <!-- <font-awesome-icon
              icon="fa-solid fa-circle-xmark"
              size="lg"
              @click="closeRoomChat()"
            /> -->
          </div>
        </div>

        <div ref="conversations" class="conversations">
          <ul v-if="box_chat.messages.length > 0">
            <li
              v-for="(item, index) in box_chat.messages"
              :key="index"
              :class="{ 'my-self': mySelf.user_id == item.sender_id }"
            >
              <div class="avatar">
                <!-- <img
                  :src="
                    mySelf.user_id == item.sender_id
                      ? mySelf?.user_avatar
                      : chatPerson?.user_avatar
                  "
                /> -->
                <span>{{ (mySelf.user_id == item.sender_id
                      ? mySelf?.user_avatar
                      : chatPerson?.user_avatar).substring(0,1) }}</span>
              </div>
              <div class="content">
                <a :href="item.attach?.link" target="_blank">
                  <img
                    v-if="item.attach?.link && typeIsImage(item.attach?.type)"
                    :src="item.attach?.link"
                    :alt="item.attach?.name"
                  />
                </a>
                <embed
                  v-if="item.attach?.link && typeIsPdf(item.attach?.type)"
                  :src="item.attach?.link"
                  type="application/pdf"
                  width="100%"
                  height="300px"
                />
                <span v-if="item.message">{{ item.message }}</span>
              </div>
            </li>
          </ul>
          <i v-else>No data of conversations</i>
          <span class="date-time-reopen" v-if="date_time_reopen != ''">{{
            date_time_reopen
          }}</span>
          <ul v-if="box_chat.messages_income.length > 0">
            <li
              v-for="(item, index) in box_chat.messages_income"
              :key="index"
              :class="{ 'my-self': mySelf.user_id == item.sender_id }"
            >
              <div class="avatar">
                <!-- <img
                  :src="
                    mySelf.user_id == item.sender_id
                      ? mySelf?.user_avatar
                      : chatPerson?.user_avatar
                  "
                /> -->
                <span>{{ (mySelf.user_id == item.sender_id
                      ? mySelf?.user_avatar
                      : chatPerson?.user_avatar).substring(0,1) }}</span>
              </div>
              <div class="content">
                <img
                  v-if="item.attach?.link && typeIsImage(item.attach?.type)"
                  :src="item.attach?.link"
                  :alt="item.attach?.name"
                />
                <embed
                  v-if="item.attach?.link && typeIsPdf(item.attach?.type)"
                  :src="item.attach?.link"
                  type="application/pdf"
                  width="100%"
                  height="300px"
                />
                <span v-if="item.message">{{ item.message }}</span>
              </div>
            </li>
          </ul>
          <div class="message-client" v-if="messageClientIsTyping">
            {{ messageClientIsTyping }}
          </div>
        </div>
        <div class="preview-attach" v-show="attachSelectedFile">
          <ValidationProvider
            ref="provider"
            rules="mimes:image/*,pdf"
            v-slot="{ errors, validate }"
            name="File"
          >
            <input
              id="attach_file"
              type="file"
              :key="fileKey"
              @change="validate"
              v-on:change="onFileChange"
            />
            <div class="info-attach">
              <span class="errors-validate" v-if="errors[0]">
                {{ errors[0] }}
              </span>
              <span
                ><font-awesome-icon
                  icon="fa-solid fa-circle-xmark"
                  size="lg"
                  @click="clearFileAttach()"
              /></span>
            </div>

            <div class="preview-image" v-if="attachPreviewUrl && attachIsImage">
              <img :src="attachPreviewUrl" alt="Preview" />
            </div>
          </ValidationProvider>
        </div>
        <div class="input-message">
          <input
            ref="inputMessage"
            placeholder="Write your messsage..."
            v-model="box_chat.message_input"
            v-on:keyup.enter="submitMessage()"
            @keydown="isTyping"
          />
          <label for="attach_file"
            ><font-awesome-icon icon="fa-solid fa-paperclip" size="lg"
          /></label>
          <font-awesome-icon
            @click="submitMessage()"
            icon="fa-solid fa-paper-plane"
            size="lg"
          />
        </div>
      </div>
      <div
        v-if="!boxChatIsShow"
        class="icon-conversations"
        @click="joinRoomChat()"
      >
        <span class="alert-new-message">{{ count_new_message }}</span>
        <font-awesome-icon
          icon="fa-solid fa-comment-dots"
          size="2xl"
          class="icon-dots-message"
          style="color: rgb(255, 199, 0);"
        />
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import moment from "moment";
import { extend } from "vee-validate";
import { mimes } from "vee-validate/dist/rules";

extend("mimes", {
  ...mimes,
  message: "Only accept image and pdf file.",
});

export default {
  name: "BoxChat",
  props: {
    orderId: {
      default: null
    },
    orderMySelf: {
      default: null,
    },
    define: {
      required: true,
    },
  },
  data: () => ({
    fileKey: 1,
    box_chat: null,
    id_my_self: "",
    pusher: null,
    channel: null,
    date_time_reopen: "",
    count_new_message: null,
    set_timeout_client_typing: null,
  }),
  created() {
    this.initData();
    this.subscribePusherChannel();
    this.getChatHistory({conversation_id: this.box_chat.conversation_id});
  },
  computed: {
    boxChatMargin: function () {
      return `bottom: ${this.define.box_chat.margin.bottom};${
        this.define.box_chat.positions
      }: ${this.define.box_chat.margin[this.define.box_chat.positions]}`;
    },
    chatPerson: function () {
      return this.box_chat.members
        ? this.box_chat.members.find(
            ({ user_id }) => user_id != this.id_my_self
          )
        : null;
    },
    mySelf: function () {
      return this.box_chat.members
        ? this.box_chat.members.find(
            ({ user_id }) => user_id == this.id_my_self
          )
        : null;
    },
    boxChatPosition: function () {
      return this.define.box_chat.positions;
    },
    boxChatIsShow: function () {
      return this.box_chat.is_show;
    },
    existRoomChat: function () {
      return this.id_my_self != "" && this.box_chat.conversation_id != "";
    },
    attachIsImage: function () {
      return this.box_chat.attach.is_image;
    },
    attachPreviewUrl: function () {
      return this.box_chat.attach.preview_url;
    },
    attachSelectedFile: function () {
      return this.box_chat.attach.selected_file;
    },
    messageClientIsTyping: function () {
      return this.box_chat.clientTyping.typing === true
        ? `${this.box_chat.clientTyping.user} is typing...`
        : "";
    },
  },
  watch: {
    "box_chat.messages"() {
      this.$nextTick(() => {
        this.scrollToBottomConversations();
      });
    },
    "box_chat.messages_income"() {
      this.$nextTick(() => {
        this.scrollToBottomConversations();
      });
    },
  },
  methods: {
    onFileChange(event) {
      if (event.target.files[0]) {
        this.box_chat.attach.selected_file = event.target.files[0];
        this.previewFile();
        this.$refs.inputMessage.focus();
        this.fileKey++;
      }
    },
    previewFile() {
      if (!this.attachSelectedFile) return;
      this.box_chat.attach.is_image =
        this.box_chat.attach.selected_file.type.includes("image");

      if (this.attachIsImage) {
        const reader = new FileReader();
        reader.onload = () => {
          this.box_chat.attach.preview_url = reader.result;
        };
        reader.readAsDataURL(this.attachSelectedFile);
      } else {
        this.box_chat.attach.preview_url = null;
      }
    },
    initData() {
      this.box_chat = {
        fileKey: 1,
        conversation_id: this.orderId,
        members: [],
        messages: [],
        messages_income: [],
        message_input: "",
        attach: {
          selected_file: null,
          preview_url: null,
          is_image: false,
        },
        is_show: false,
        clientTyping: {
          user: "",
          typing: false,
        },
      };
      this.id_my_self = this.orderMySelf;
      this.pusher = null;
      this.channel = null;
      this.date_time_reopen = "";
      this.count_new_message = 0;
    },
    clearFileAttach() {
      this.box_chat.attach = {
        selected_file: null,
        preview_url: null,
        is_image: false,
      };
    },
    async showPopupChooseUser() {
      const userId = this.orderMySelf;
      if (userId) {
        this.id_my_self = userId;
        this.getChatHistory({
          conversation_id: this.box_chat.conversation_id,
        });

        this.subscribePusherChannel();
      }
    },
    subscribePusherChannel() {

      this.channel = Pusher.subscribe(this.define.pusher_channel_name);
      let _this = this;
      this.channel.bind(this.define.pusher_event_name, function (data) {
        _this.incommingMessages(data.message);
      });

      this.channel.bind(
        this.define.pusher_client_event_typing,
        function (data) {
          _this.box_chat.clientTyping = data;
          _this.scrollToBottomConversations();
          clearTimeout(this.set_timeout_client_typing);

          // remove is typing indicator after 0.9s
          this.set_timeout_client_typing = setTimeout(function () {
            _this.box_chat.clientTyping = {
              user: "",
              typing: false,
            };
          }, 900);
        }
      );
    },
    isTyping() {
      this.channel.trigger(this.define.pusher_client_event_typing, {
        user: this.mySelf.user_name,
        typing: true,
      });
    },
    getChatHistory(conversationId) {
      axios.get("/p2p/get-history", { params: conversationId })
      .then((response) => {
        const { conversation_id, members, messages } = response.data.data;
        if (conversation_id && members && messages) {
          this.box_chat.conversation_id = conversation_id;
          this.box_chat.members = members;
          this.box_chat.messages = messages;
        }
      });
      this.showBoxChat();
    },
    joinRoomChat() {
      if (this.existRoomChat) {
        // If room chat is exist => Show Box chat
        this.showBoxChat();
        this.resetCountNewMessage();
        this.scrollToBottomConversations();
      } else {
        // If room chat is NOT exist => Show popup choose user
        this.showPopupChooseUser();
      }
    },
    // closeRoomChat() {
    //   this.$swal({
    //     title: "Are you sure?",
    //     text: "Do you still want to leave this conversation!",
    //     icon: "warning",
    //     showCancelButton: true,
    //     confirmButtonColor: "#3085d6",
    //     cancelButtonColor: "#d33",
    //     confirmButtonText: "Yes, leave it!",
    //   }).then((result) => {
    //     if (result.isConfirmed) {
    //       this.channel.unsubscribe();
    //       this.initData();
    //     }
    //   });
    // },
    showBoxChat() {
      this.box_chat.is_show = true;
    },
    hideBoxChat() {
      this.box_chat.is_show = false;
    },
    resetCountNewMessage() {
      this.count_new_message = 0;
    },
    incommingMessages(msg) {
      if (this.date_time_reopen == "") {
        this.date_time_reopen = moment().format("YYYY/MM/DD HH:mm");
      }
      this.box_chat.messages_income.push(msg);

      // Update count new message
      this.count_new_message =
        !this.boxChatIsShow && msg.sender_id != this.id_my_self
          ? this.count_new_message + 1
          : 0;
    },
    submitMessage() {
      this.$refs.provider.validate().then((result) => {
        if (result.valid) {
          if (this.box_chat.message_input || this.attachSelectedFile) {
            const formData = new FormData();
            formData.append("user_id", this.id_my_self);
            formData.append("conversation_id", this.box_chat.conversation_id);
            if (this.attachSelectedFile) {
              formData.append("attach", this.attachSelectedFile);
            }
            if (this.box_chat.message_input) {
              formData.append("message", this.box_chat.message_input);
            }

            axios.post("/p2p/push-message", formData);
            this.box_chat.message_input = "";
            this.clearFileAttach();
          }
        }
      });
    },
    scrollToBottomConversations() {
      this.$nextTick(() => {
        const conversations = this.$refs.conversations;
        if (conversations) {
          conversations.scrollTop =
            conversations.scrollHeight - conversations.clientHeight;
        }
      });
    },
    typeIsImage(type) {
      return type.includes("image") ? true : false;
    },

    typeIsPdf(type) {
      return type.includes("pdf") ? true : false;
    },

    truncateString(str, maxLength) {
      if (str.length <= maxLength) {
        return str;
      } else {
        var truncatedStr = str.substring(0, maxLength) + "...";
        return truncatedStr;
      }
    },
  },
};
</script>

<style lang="scss" scoped>
$background: #eef2f6;

.area-chat {
  position: absolute;
  .icon-conversations {
    cursor: pointer;
    position: relative;
    .alert-new-message {
      text-align: center;
      background: red;
      color: white;
      position: absolute;
      right: -8px;
      top: -8px;
      width: 25px;
      line-height: 25px;
      height: 25px;
      border-radius: 1000px;
    }
    svg {
      font-size: 3em;
      path {
        color: rgb(255, 199, 0) !important;
      }
    }
  }

  .box-chat {
    background: #fff;
    width: 100%;
    max-width: 390px;
    height: 100%;
    max-height: 600px;
    display: flex;
    flex-direction: column;
    box-shadow: 0px 0px 10px 5px rgba(118, 118, 118, 0.29);

    .box-title {
      display: flex;
      align-items: center;
      padding: 10px;
      background: $background;

      .avatar {
        width: 35px;
        height: 35px;
        span {
          width: 30px;
          height: 30px;
          line-height: 30px;
          text-align: center;
          background-color: #007bff;
          color: #fff;
          border-radius: 50%;
          display: inline-block;
        }
      }

      .name {
        text-align: left;
        flex-grow: 1;
        margin-left: 10px;
      }
    }
    .conversations {
      overflow-y: scroll;
      padding: 5px 10px;
      flex-grow: 1;
      ul {
        padding: 0;
        margin: 0;

        li {
          list-style: none;
          margin: 15px 0;
          display: flex;
          align-items: flex-start;
          justify-content: flex-start;

          &.my-self {
            justify-content: flex-end;
            .content {
              background-color: #ffffff;
              border: 1px solid #eef2f6;
              order: 1;
              margin-right: 8px;
            }

            .avatar {
              order: 2;
              span {
                width: 30px;
                height: 30px;
                line-height: 30px;
                text-align: center;
                background-color: #ffffff;
                color: #007bff;
                border: #007bff solid 1px;
                border-radius: 50%;
                display: inline-block;
              }
            }
          }
          .content {
            background-color: $background;
            border-radius: 8px;
            padding: 8px;
            line-height: 16pt;
            text-align: left;
            order: 2;
            margin-left: 8px;

            img {
              max-width: 100%;
            }
          }
          .avatar {
            order: 1;
            img {
              width: 35px;
            }
            span {
              width: 30px;
              height: 30px;
              line-height: 30px;
              text-align: center;
              background-color: #007bff;
              color: #fff;
              border-radius: 50%;
              display: inline-block;
            }
          }
        }
      }

      .message-client {
        font-style: italic;
        color: #999;
        text-align: left;
        font-size: 11pt;
      }
      .date-time-reopen {
        justify-content: center;
        padding: 15px 0;
        font-size: 11pt;
        display: block;
      }
    }

    .preview-attach {
      padding-top: 10px;
      margin: 0 5px;
      border-top: 1px solid #e5e5e5;
      max-height: 100%;

      .errors-validate {
        color: red;
      }
      .file-name {
        color: green;
      }

      .info-attach {
        display: flex;
        justify-content: space-between;
      }
      .preview-image {
        max-height: 100%;
        max-width: 15%;
        overflow: hidden;
        margin-top: 8px;
        img {
          overflow: hidden;
        }
      }

      input {
        display: none;
      }
    }

    .input-message {
      display: flex;
      padding: 10px;
      margin: 0 5px;
      align-items: center;
      justify-content: space-between;

      input {
        flex-grow: 1;
        padding: 0 8px;
        height: 38px;
        font-size: 12pt;
        border: 1px solid #eef2f6;
        background: transparent;
        margin-right: 5px;

        &:focus {
          outline: none;
        }
      }
    }

    svg {
      cursor: pointer;
      padding: 0 5px;
    }
  }
}

/* Dành cho điện thoại */
@media all and (max-width: 600px) {
  .area-chat {
    bottom: 0 !important;
    left: 0 !important;
    right: 0 !important;
    top: 0px;

    .icon-conversations {
      position: absolute;
      bottom: 10px;
    }

    &.left .icon-conversations {
      left: 15px;
    }

    &.right .icon-conversations {
      right: 15px;
    }

    .box-chat {
      box-shadow: none;
      max-height: none;
      max-width: none;
    }
  }
}
</style>
