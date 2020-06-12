<template>
    <div>
        <div class="m-portlet__body">
            <div class="row print_links">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <a class="btn btn-primary btn-sm m-btn  m-btn m-btn--icon" href="#"
                       onclick="window.print();return false"><span><i
                        class="fa flaticon-technology"></i><span>Print</span></span></a>
                    <a class="btn btn-accent btn-sm m-btn  m-btn m-btn--icon" href="#"><span><i
                        class="fa flaticon-doc"></i><span>PDF</span></span></a>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-12">
                    <div class="m-portlet">
                        <div class="m-portlet__body m-portlet__body--no-padding">
                            <div class="m-invoice-2">
                                <div class="m-invoice__wrapper">
                                    <div class="m-invoice__head">
                                        <div class="m-invoice__container m-invoice__container--centered">
                                            <div class="m-invoice__items" style="margin-top:-50px;">
                                                <div class="m-invoice__item ">
                                                    <span
                                                        class="m-invoice__subtitle text-center">Video Calling Logs</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-invoice__body m-invoice__body--centered" style="margin-top: -50px;">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>SL#</th>
                                                    <th class="text-right">Participant Status</th>
                                                    <th class="text-right">Participant Identity</th>
                                                    <th class="text-right">Status Callback Event</th>
                                                    <th class="text-right">Track Kind</th>
                                                    <th class="text-right">Participant Duration</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(item, index) in form.details">
                                                    <td>{{++index}}</td>
                                                    <td class="text-right">{{ item.ParticipantStatus }}</td>
                                                    <td class="text-right">{{ item.ParticipantName }}</td>
                                                    <td class="text-right">{{ item.StatusCallbackEvent }}</td>
                                                    <td class="text-right">{{ item.TrackKind }}</td>
                                                    <td class="text-right">{{ item.ParticipantDuration }}
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['editId'],

        data: function () {
            return {
                show_list: false,
                view_form: true,

                form: {
                    details: [
                        {
                            twilio_video_id: '',
                            SequenceNumber: '',
                            ParticipantStatus: '',
                            user_name: '',
                            ParticipantName: '',
                            ParticipantIdentity: '',
                            StatusCallbackEvent: '',
                            TrackKind: '',
                            ParticipantDuration: '',
                            RawData: '',
                        }
                    ],
                },
            };
        },

        methods: {
            show(id) {
                var _this = this;
                axios.get(base_url + 'report-video-calls/' + id)
                    .then((response) => {
                        _this.form = response.data.data;
                    });
            },
        },

        mounted() {
            var _this = this;
        },

        created() {
            var _this = this;
            _this.show(_this.editId);
        }
    }
</script>
