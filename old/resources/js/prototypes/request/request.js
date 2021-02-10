class Request {
    url() {
        return new URL(window.location.href);
    }

    has(query) {
        return this.query(query) !== null;
    }

    query(param) {
        return this.url().searchParams.get(param);
    }

    params() {
        return this.url().searchParams;
    }
}

export default Request;
