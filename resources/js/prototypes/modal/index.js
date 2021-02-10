import Vue from 'vue'

Vue.prototype.$modal = function (modal, props = {}) {
    let ModalComponent = Vue.extend(modal);

    let instance = new ModalComponent({
        propsData: {
            ...props
        }
    });

    instance.$mount();

    document.querySelector('main').appendChild(instance.$el);

    return instance.show();
};
