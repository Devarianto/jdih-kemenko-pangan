export default() => ({
  config:{
    baseHtml: '',
    placeClone: '',
    buttonAdd: '',
    buttonRemove: '',
    buttonRemoveType: 'single',
    maxLength: 5,
    minLength: 1,

  },
  callback : {
    onAdd(html, length){},
    onRemove(length){}
  },
  setConfig(config){
    if(config)
      this.config = {
        ...this.config,
        ...config
      }
  },
  setCallback(callback){
    if(callback)
      this.callback = {
        ...this.callback,
        ...callback
      }
  },
  appendClone(){
    const baseHtml = this.config.baseHtml
    const placeClone  = this.config.placeClone
    const currentLength = placeClone.find("> *").length
    const maxLength = this.config.maxLength

    if(currentLength < maxLength){
      baseHtml.clone().appendTo(placeClone)
      const lastAdded = placeClone.find("> *:last-child")
      this.callback.onAdd(lastAdded, currentLength + 1)
    }

  },
  removeCloneGeneral(){
    const placeClone  = this.config.placeClone
    const currentLength = placeClone.find("> *").length
    const minLength = this.config.minLength

    if(currentLength > minLength){
      placeClone.find("> *:last-child").remove()
      this.callback.onRemove(currentLength - 1)
    }
  },
  removeCloneSingle(button){
    const placeClone  = this.config.placeClone
    const currentLength = placeClone.find("> *").length
    const minLength = this.config.minLength
    const clonedHtml = button.parents(`.${this.config.baseHtml.attr('class').split(' ')[0]}`)

    if(currentLength > minLength){
      this.callback.onRemove(currentLength - 1)
      clonedHtml.remove()
    }
  },
  init(){
    const buttonAdd = this.config.buttonAdd
    const buttonRemove = this.config.buttonRemove
    const buttonRemoveType = this.config.buttonRemoveType
    const placeClone = this.config.placeClone

    if(buttonAdd){
      buttonAdd.on('click',(e)=>{
        e.preventDefault()
        this.appendClone()
      })
    }

    if(buttonRemove && buttonRemoveType === 'single'){
      buttonRemove.on('click',(e)=>{
        e.preventDefault()
        this.removeClone()
      })
    }else if(buttonRemove && buttonRemoveType === 'multiple'){
      placeClone.on('click', buttonRemove,(e)=>{
        e.preventDefault()
        this.removeCloneSingle($(e.target))
      })
    }

  }
})