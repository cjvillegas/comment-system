<template>
	<div class="mt-2">
		<div class="d-flex full-width align-items-center position-relative">
			<img src="/images/no-image-user.png" class="user-image-round mr-3 mb-auto" alt="...">
			<div class="ml-10px full-width">
				<el-card class="box-card text-gray comment-box full-width">
				  	{{ localComment.content }}

				  	<div class="mt-2">
				  		{{ dateFormat(localComment.created_at) }}
				  	</div>
				</el-card>

				<el-button
					v-if="localComment.level < 3"
					type="text"
					@click="showReplyForm(localComment)">
					Reply
				</el-button>

				<template v-if="localComment.children && localComment.children.length">
					<base-comment-box
						v-for="cCom in localComment.children"
						:key="cCom.id"
						:post-id="postId"
						:comment="cCom">
					</base-comment-box>
				</template>

				<base-comment-form
					:level="localComment.level + 1"
					v-if="localComment.show_reply"
					:parent-id="localComment.id"
					:post-id="postId">
				</base-comment-form>
			</div>
		</div>
	</div>
</template>

<script>
	import cloneDeep from 'lodash/cloneDeep'
	import moment from 'moment'

	export default {
		name: 'BaseCommentBox',
		props: {
			postId: {
				required: true
			},
			comment: {
				required: true,
				type: Object
			}
		},
		data() {
			return {
				localComment: cloneDeep(this.comment)
			}
		},
		methods: {
			showReplyForm(com) {
				com.show_reply = true
			},
			dateFormat(date) {
				return moment(date).format('MMM DD, YYYY - hh:mm a')
			}
		},
		watch: {
			comment: {
				handler() {
					this.localComment = cloneDeep(this.comment)	
				},
				deep: true
			}
		}
	}
</script>

<style lang="scss">
	
</style>