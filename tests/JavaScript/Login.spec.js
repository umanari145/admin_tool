import { shallowMount } from '@vue/test-utils'
import LoginComponent from '../../resources/js/components/LoginComponent.vue'

describe('LoginComonent', () => {
  test('loginSample', () => {
    const wrapper = shallowMount(LoginComponent)
    console.log(wrapper.vm)
  })
})