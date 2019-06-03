<template>
	<div>
		<panel-item :field="field">
			<div slot="value">{{ currentLocaleName }} ({{ field.locale }})</div>
		</panel-item>
		<div class="flex border-b border-40">
			<div class="w-1/4 py-4">
				<h4 class="font-normal text-80">Is Translated?</h4>
			</div>
			<div class="w-3/4 py-4">
				<span
					class="inline-block rounded-full w-2 h-2 mr-1"
					:class="{
						'bg-success': field.value.isTranslated,
						'bg-danger': !field.value.isTranslated
					}"
				/>
				<span>{{ label }}</span>
			</div>
		</div>
	</div>
</template>
<script>
export default {
	props: ["resource", "resourceName", "resourceId", "field"],
	computed: {
		currentLocaleName() {
			let name = null;

			Object.keys(this.field.locales).forEach(locale => {
				if (locale === this.field.locale) {
					name = this.field.locales[locale];
				}
			});

			return name;
		},
		label() {
			return this.field.value.isTranslated == true
				? this.__("Yes")
				: this.__("No");
		}
	}
};
</script>
