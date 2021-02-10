import Vue from "vue";

Vue.prototype.$trans = (string, args) => {
    let value = _.get(window.messages, string);

    _.eachRight(args, (paramVal, paramKey) => {
        value = _.replace(value, `:${paramKey}`, paramVal);
    });

    return value;
};
