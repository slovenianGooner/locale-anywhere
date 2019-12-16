<template>
  <div class="ml-auto">
    <delete-toolbar-button
      v-if="
				canDeleteTranslations &&
					resource.authorizedToDelete &&
					!resource.softDeleted
			"
      :resource="resource"
      :resourceName="resourceName"
      :resourceId="resourceId"
    ></delete-toolbar-button>
  </div>
</template>
<script>
export default {
  props: ['resourceName', 'resourceId', 'resource'],

  components: {
    'delete-toolbar-button': require('./DeleteToolbarButton')
  },

  computed: {
    canDeleteTranslations() {
      let can = false

      this.resource.fields.forEach(field => {
        if (field.locales !== undefined) {
          can = true
        }
      })

      return can
    }
  }
}
</script>
