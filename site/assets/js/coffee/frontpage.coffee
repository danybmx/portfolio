requestAnimationFrame = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.msRequestAnimationFrame || window.oRequestAnimationFrame || (callback) -> setTimeout(callback, 1)
easeOutBounce = (pos) ->
  if pos < (1/2.75)
    return (7.5625*pos*pos)
  else if pos < (2/2.75)
    return (7.5625*(pos-=(1.5/2.75))*pos + 0.75)
  else if pos < (2.5/2.75)
    return (7.5625*(pos-=(2.25/2.75))*pos + 0.9375)
  else
    return (7.5625*(pos-=(2.625/2.75))*pos + 0.984375)

if document.getElementsByClassName('error').length > 0
  window.location.href += '#get-in-touch-anchor'

if document.getElementById 'welcome'
  intro_text_el = document.getElementById 'intro-text'
  change_text_el = intro_text_el.getElementsByClassName('write')[0]
  text_strings = change_text_el.dataset.strings.split('|')
  initial_pause = 1000
  selection_pause = 3000
  end_pause = 1000
  char_pause = 100
  text_index = 0

  animate = (word) ->
    intro_text_el.classList.remove('selected')
    change_text_el.innerHTML = ''
    i = 0
    for letter in word
      setTimeout () ->
        change_text_el.innerHTML += word[change_text_el.innerHTML.length]
      , i++ * char_pause + initial_pause

    setTimeout () ->
      intro_text_el.classList.add('selected')
    , initial_pause + i * char_pause + selection_pause

    setTimeout () ->
      if ++text_index >= text_strings.length
        text_index = 0
      animate(text_strings[text_index])
    , initial_pause + i * char_pause + selection_pause + end_pause
  
  animate text_strings[text_index]

  # Skills
  skills_container = document.getElementById 'skills'
  skills_elements = skills_container.getElementsByClassName 'skill'

  progressBars = (step = 0) ->
    canvases = document.getElementsByTagName 'canvas'

    for canvas in canvases
      padding = 10
      lineWidth = 10
      x = canvas.width / 2
      y = canvas.height / 2
      radius = x - padding - lineWidth / 2
      percent = parseInt(canvas.dataset.progress) * step

      start = 1.5 * Math.PI
      end = start + 2 * percent / 100 * Math.PI

      ctx = canvas.getContext '2d'
      ctx.clearRect(0, 0, canvas.height, canvas.width)
      ctx.beginPath()
      ctx.arc(x, y, radius, start, end)
      ctx.lineWidth = lineWidth
      ctx.stroke()

  start = null
  animateSkills = () ->
    duration = 2000
    start = (new Date()).getTime() if ! start
    diff = (new Date()).getTime() - start
    if diff > duration
      progressBars(1)
    else
      step = diff / duration
      progressBars easeOutBounce(step)
      setTimeout(animateSkills, requestAnimationFrame)
    

  for skill in skills_elements
    name = skill.dataset.name
    name_el = document.createElement 'span'
    name_el.classList.add('name')
    name_el.innerHTML = name
    progress = skill.dataset.percent
    progress_el = document.createElement 'canvas'
    progress_el.dataset.progress = progress
    progress_el.width = progress_el.height = 280
    percent_el = document.createElement 'span'
    percent_el.classList.add('percent')
    percent_el.innerHTML = progress+'%'
    skill.appendChild(name_el)
    skill.appendChild(percent_el)
    skill.appendChild(progress_el)

  # Header
  header = document.getElementsByTagName('header')[0]

  articles = document.getElementsByTagName('article')
  wheight = window.innerHeight
  divs = document.querySelectorAll('.parallax')
  skills_container = document.getElementById 'skills'
  skills = skills_container.getElementsByClassName 'skill'
  works_container = document.getElementById 'works'
  works = works_container.getElementsByClassName 'block-wrapper'

  window.addEventListener 'scroll', () ->
    scroll_top = document.body.scrollTop

    if scroll_top > 60
      header.classList.add('white')
    else
      header.classList.remove('white')

    # Get current article
    active = document.body.querySelector('#navigation a.active')

    if active
      active.classList.remove('active')

    current_article = ''
    for article in articles
      rect = article.getBoundingClientRect()
      if rect.top < wheight / 2
        current_article = article

    current_article_el = document.getElementById('navigation').querySelector('.'+current_article.id)
    if current_article_el
      current_article_el.classList.add('active')

    # Parallax
    for div in divs
      speed = parseInt(div.dataset.speed) / 100 || 0.1
      vpos = scroll_top * speed
      div.style.backgroundPosition = '50% calc(50% + '+vpos+'px)'

    # Skill animation
    animated = false
    if animated is false and skills_container.getBoundingClientRect().top < wheight / 2
      animated = true
      animateSkills()

    # Works animations
    for work in works
      if work.getBoundingClientRect().top < wheight
        work.classList.add 'in'
