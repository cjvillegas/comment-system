import Vue from 'vue'

export default class EventDispacher{
	constructor() {
		this.vue = new Vue()
	}

	/**
	 * Fires a custom event
	 *
	 * @param event <string> - the event name being fired
	 * @param data <mixed> - data passed withe the event
	 */
	fire(event, data = null) {
		this.vue.$emit(event, data)
	}

	/**
	 * Listens to custom events
	 *
	 * @param event <string> - the event name being fired
	 * @param callback <callback> - method being called after receiving the event
	 */
	listen(event, callback) {
		this.vue.$on(event, callback)
	}

	// Destroy an event or all events
	destroy(event = null, callback = null) {
		if (event == null && callback == null) {
			this.vue.$off()
			return
		} else if (event == null) {
			this.vue.$off([event])
			return 
		} 
		this.vue.$off([event, callback])
	}
}
