<script>
    export default {
        data() {
            return {
                myAxios: null,
                isInXHR: false,
                XHRCount: 0,
            }
        },
        mounted() {
            this.myAxios = axios.create();
            this.myAxios.interceptors.request.use((config) => {
                this.beforeRequest();
                return config;
            }, (error) => {
                this.errorRequest();
                return Promise.reject(error);
            });
            this.myAxios.interceptors.response.use((response) => {
                this.afterRequest();
                return response;
            }, (error) => {
                this.errorRequest();
                return Promise.reject(error);
            });
        },
        methods: {
            beforeRequest() {
                this.isInXHR = true;
                this.XHRCount++;
            },
            errorRequest() {
                this.isInXHR = false;
                this.XHRCount--;
            },
            afterRequest() {
                this.isInXHR = false;
                this.XHRCount--;
            }
        }
    }
</script>