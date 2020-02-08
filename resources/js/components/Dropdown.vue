<template>
    <div class="dropdown">
        <div class="dropdown-toggle"
             aria-haspopup="true"
             :aria-expanded="isOpen"
             @click="isOpen = ! isOpen">
            <slot name="trigger"></slot>
        </div>
        <div class="dropdown-menu absolute bg-card py-2 rounded shadow mt-2"
            v-show="isOpen"
             :class="align === 'left'? 'pin-l' : align "
             :style="{width}"
        >
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            align: {default: 'left'},
            width: {default: 'auto'}
        },
        data() {
            return {
                isOpen: false
            }
        },
        methods: {
            say: function (message) {
                alert(message)
            },
            expand(event) {
                if (! event.target.closest('.dropdown')) {
                    this.isOpen = false;
                    document.removeEventListener('click', this.expand);
                }
            }
        },

        watch: {
            isOpen(val) {
                if (val) {
                    document.addEventListener('click', this.expand)
                }
            }
        }
    }
</script>
