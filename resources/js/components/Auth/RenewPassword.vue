<template>
    <div class="row" id="auth"  data-aos="fade-down">
        <div class="col-6 d-none d-md-block left-side">
            <div class="d-flex container flex-column d-flex align-items-center justify-content-center">
                <img src="/assets/images/auth/forgot_password.png" class="w-100" />
            </div>
        </div>
        <div class="col-md-6 col-sm-12 right-side" v-loading="loading" element-loading-text="Verificando credenciais">
            <div class="container d-flex flex-column justify-content-center">
                <text-logo />
                <b>Renove sua senha</b>
                <small>Digite a nova senha e a confirme para renovar</small>
                <form v-on:submit.prevent="submit">
                    <div class="d-flex flex-column mb-2">
                        <label class="label-input">Senha</label>
                        <input class="form-control" v-model="form.password" type="password" required />
                    </div>
                    <div class="d-flex flex-column">
                        <label class="label-input">Confirme a senha</label>
                        <input class="form-control" v-model="form.password_confirmation" type="password" required />
                    </div>
                    <div class="d-flex flex-column mt-3">
                        <button class="btn btn-block btn-primary b-0">Renovar a senha</button>
                    </div>
                </form>
                <small> Deseja voltar ao login ? <a href="/login" class="f-12">Clique aqui</a> </small>
            </div>
        </div>
    </div>
</template>
<<script>
export default {
	props : ["token"],
	data() {
		return {
			loading : false,
			form : {
				password : "",
				password_confirmation : "",
			},
		}
	},
	methods : {
		submit() {
            this.loading = true;
            this.$http.post(`/esqueci-a-senha/${this.token}`, this.form).then(({data}) => {   
                if(!data.success) {
					this.$message(data.message)
					return this.loading = false
				}
				window.location.href = data.route
            }).catch(er => {
				this.loading = false
                this.errors = er.response.data.errors
                this.$validationErrorMessage(er)
			})
		}
	}
}
</script>
<style lang="scss" scoped>
#auth {
    &.row {
        height: 100%;
        .left-side {
            height: 100%;
            .container {
                padding: 0 100px;
                height: 100%;
            }
            border-right: 1px solid #efefef;
        }

        .right-side {
            background-color: white;
            .container {
                height: 100%;
                padding: 0 180px;
                .title {
                    color: #001737;
                    font-weight: 500;
                    line-height: 1.25;
                }
                small {
                    color: #8392a5;
                    font-size: 12px;
                }
                form {
                    border-top: 1px solid #f1f1f1;
                    margin-top: 10px;
                    padding-top: 10px;
                }
            }
        }
    }
}
</style>