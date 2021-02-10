import Vue from 'vue'
import ModalConfirm from '@/components/modal-confirm'

Vue.prototype.$confirm = function (message, options = {}) {
    let ModalComponent = Vue.extend(ModalConfirm);

    let instance = new ModalComponent({
        propsData: {
            message: message,
            ...options
        }
    });

    instance.$mount();
    document.querySelector('main').appendChild(instance.$el);

    return instance.show();
};
