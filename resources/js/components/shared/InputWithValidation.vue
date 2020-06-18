<template>
    <ValidationProvider :vid="vid" :name="$attrs.name" :rules="rules" v-slot="slotProps">
        <a-form-item
            :label="$attrs.label"
            hasFeedback
            :validateStatus="resolveState(slotProps)"
            :help="slotProps.errors[0]"
        >
            <a-input :type="$attrs.type" :placeholder="$attrs.placeholder" v-model="innerValue">
                <a-icon v-if="$attrs.icon" slot="prefix" :type="$attrs.icon" style="color: rgba(0,0,0,.25)" />
            </a-input>
        </a-form-item>
    </ValidationProvider>
</template>

<script>

    export default {
        props: {
            vid: {
                type: String
            },
            rules: {
                type: [Object, String],
                default: ""
            },
            // must be included in props
            value: {
                type: null
            }
        },
        data: () => ({
            innerValue: ""
        }),
        watch: {
            // Handles internal model changes.
            innerValue(newVal) {
                this.$emit("input", newVal);
            },
            // Handles external model changes.
            value(newVal) {
                this.innerValue = newVal;
            }
        },
        created() {
            if (this.value) {
                this.innerValue = this.value;
            }
        },
        methods: {
            resolveState({errors, pending, valid}) {
                if (errors[0]) {
                    return "error";
                }

                if (pending) {
                    return "validating";
                }

                if (valid) {
                    return "success";
                }

                return "";
            }
        }
    };
</script>
