<template>
    <td>
        <b-form-input 
            :state="error_state" 
            v-model="item_value" 
            @blur="updateItem"
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
            updateItem() {
                this.error_state = null;
                let valid = this.validateInput();
                if (valid) {
                    this.$emit('input', this.item_value)
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
        },
        destroyed() {
            EventBus.$off('VALIDATE_MATRIX_ITEMS', this.validateInput);
        }
    }
</script>

<style lang="scss" scoped>

</style>