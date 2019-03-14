<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Make a Charge</div>

                    <div class="card-body">
                        <fieldset>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="email">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="email" id="email"
                                           placeholder="Email Receipt" v-model="email">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="description">Description</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="description" id="description"
                                           placeholder="Debit/Credit Card Number" v-model="description">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="card-number">Card Number</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="card-number" id="card-number"
                                           placeholder="Debit/Credit Card Number" autocomplete="cc-number" v-model="card.card_number">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="expiry-month">Expiration Date</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <select class="form-control col-sm-2" name="expiry-month" id="expiry-month"
                                                autocomplete="cc-exp-month" v-model="card.expiry_month">
                                                <option>Month</option>
                                                <option value="01">Jan (01)</option>
                                                <option value="02">Feb (02)</option>
                                                <option value="03">Mar (03)</option>
                                                <option value="04">Apr (04)</option>
                                                <option value="05">May (05)</option>
                                                <option value="06">Jun (06)</option>
                                                <option value="07">Jul (07)</option>
                                                <option value="08">Aug (08)</option>
                                                <option value="09">Sep (09)</option>
                                                <option value="10">Oct (10)</option>
                                                <option value="11">Nov (11)</option>
                                                <option value="12">Dec (12)</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-3">
                                            <select class="form-control" name="expiry-year" autocomplete="cc-exp-year" v-model="card.expiry_year">
                                                <option>Year</option>
                                                <option value="19">2019</option>
                                                <option value="20">2020</option>
                                                <option value="21">2021</option>
                                                <option value="22">2022</option>
                                                <option value="23">2023</option>
                                                <option value="24">2024</option>
                                                <option value="25">2025</option>
                                                <option value="26">2026</option>
                                                <option value="27">2027</option>
                                                <option value="28">2028</option>
                                                <option value="29">2029</option>
                                                <option value="30">2030</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="cvv">Card CVV</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="cvv" id="cvv" placeholder="Security code"
                                        autocomplete="cc-csc" v-model="card.cvv">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="button" class="btn btn-success">Pay Now</button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                card: {
                    card_number: null,
                    expiry_year: null,
                    expiry_month: null,
                    cvv: null
                },
                amount: 0,
                email: null,
                description: null
            }
        },
        methods: {
            createCharge() {
                axios.post('/api/charge', {
                    card: this.card,
                    amount: this.amount,
                    description: this.description
                }).then(data => {
                    alert('success!');
                }).catch(error=> {
                    alert(error.message);
                });
            }
        }
    }
</script>
