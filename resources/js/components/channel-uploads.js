Vue.component('channel-uploads', {
    props: {
        channel: {
            type: Object,
            required: true,
            default: () => []
        }
    },

    data: () => ({
        selected: false,
        videos: [],
        uploads: [],
        progress: {},
        intervals: {}
    }),
    
    methods: {
        upload() {

            this.selected = true;
            this.videos = Array.from(this.$refs.videos.files);

            const Uploader = this.videos.map(video => {

                const form = new FormData()
                this.progress[video.name] = 0

                form.append('video', video)
                form.append('title', video.name)

                return axios.post(`/channels/${this.channel.id}/video`, form, {
                    onUploadProgress: (event) => {

                        this.progress[video.name] = Math.ceil(event.loaded/event.total*100)
                        this.$forceUpdate()
                    }
                }).then(({data}) => {
                    this.uploads = [...this.uploads, data]
                    console.log(data);
                })
            });

            axios.all(Uploader).then(() => {
                this.videos = this.uploads

                this.videos.forEach(video => {

                    this.intervals[video.id] = setInterval(() => {

                        axios.get(`/videos/${video.id}`).then(({data}) => {
                                if (data.percentage == 100) {
                                    clearInterval(this.intervals[video.id])
                                }

                                this.videos = this.videos.map(v => {
                                    return v.id === data.id ? data : v
                                })
                            }
                        )

                    }, 3000)
                })
            })
        }
    }
});