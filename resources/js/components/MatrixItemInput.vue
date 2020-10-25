<template>
    <td>
        <b-form-input 
            :state="error_state" 
            v-model="item_value" 
            @blur="updateItem"
            class="min-width-70"
        ></b-form-input>
    </td>
</template>

<script>
    import EventBus from '@/EventBus';

    export default {
        data() {
            return {
                item_value: null,
                error_state: null
            }
        },
        props: ['value'],
        methods: {
            fillRandomly() {
                this.item_value = Math.floor(Math.random() * 10);
                this.$emit('input', this.item_value);
            },
            updateItem() {
                this.error_state = null;
                let valid = this.validateInput();
                if (valid) {
                    this.$emit('input', this.item_value);
                }
            },
            validateInput() {
                let number_pattern = /^(-|\+)?[0-9]+(\.[0-9]+)?$/;
                if (!this.item_value || !number_pattern.test(this.item_value)){
                    this.error_state = false;
                    return false;
                } 

                this.error_state = true;
                return true;
            }
        },
        created() {
            EventBus.$on('VALIDATE_MATRIX_ITEMS', this.validateInput);
            EventBus.$on('FILL_INPUTS_RANDOMLY', this.fillRandomly);
        },
        destroyed() {
            EventBus.$off('VALIDATE_MATRIX_ITEMS', this.validateInput);
            EventBus.$off('FILL_INPUTS_RANDOMLY', this.fillRandomly);
        }
    }
</script>

<style lang="scss" scoped>
    .min-width-70{
        min-width: 70px;
    }
</style>