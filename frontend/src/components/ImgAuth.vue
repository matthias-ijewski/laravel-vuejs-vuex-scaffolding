<template>
    <img :src="base64" />
</template>
<script>
// import axios from 'axios';
export default {
    props: ['src', 'w', 'h'],
    data() {
        return {
            base64: ''
        };
    },
    created() {
        this.fetchImg();
    },
    watch: {
        src() {
            this.fetchImg();
        }
    },
    methods: {
        addUrlParam(param) {
            let src = this.src;
            src += (src.split('?')[1] ? '&' : '?') + param;
            return src;
        },
        fetchImg() {
            if (this.src) {
                //
                // if width or height is specified, append to url
                var src = this.src;
                if (this.w) src = this.addUrlParam('w=' + this.w);
                if (this.h) src = this.addUrlParam('h=' + this.h);
                //
                this.$http
                    .get(src, {
                        responseType: 'arraybuffer'
                    })
                    .then(r => {
                        this.base64 =
                            'data:' +
                            r.headers['content-type'] +
                            ';base64,' +
                            Buffer.from(r.data, 'binary').toString('base64');
                    });
            } else {
                console.log('this.src is undefined in ImgAuth.vue');
            }
        }
    }
};
</script>
