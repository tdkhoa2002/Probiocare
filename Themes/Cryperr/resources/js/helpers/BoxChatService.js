import axios from "axios";

export default {
  getConversations(params) {
    return axios.get("get-history", {
      params: params,
    });
  },
  pushMessage(params) {
    return axios.post("push-message", params);
  },
};
