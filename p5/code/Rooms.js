function loadRooms(){
rooms = [


    //startroom
new room(-100, 10000, 0, 'Choose encounter',

'Pepe', "encounter", 'pepes_bread', "",
'Card', "encounter", 'card_game', "",
'Running', 'encounter', 'ernst_running', '',
'River', 'encounter', 'flappy_river', true,
"next page", 'tp', -1, 0),

new room(-100, -1, 0, 'Choose encounter',

'Invaders', "encounter", 'wasp_invaders', "",
'Mountain', "encounter", 'mountain_jump', "",
'Frog', 'encounter', 'frog_king', '',
'DDR', 'encounter', 'ddr', '',
"back", 'tp', 0, 0),

  new room(-10, 0, 0, 'You wake up on a beach. Unsure of where you are and how you got there you take a look around. There is an island far out on the ocean. Other than that the rest of the sea is barren. You hear the sound of waves and seagulls. Dizzyness brings you back to sleep...',

  'Reopen your eyes', "move", 1, "y",
  " tp current pos", "tp", 10, 22,
  " ", 'encounter', 'pepes_bread', '',
  " ", '', '', '',
  " ", '', '', ''),

  new room(1, 0, 1, 'Someone is dragging you across the sand. They are bringing you away from the ocean towards a large castle in the distance. Yet again you struggle to keep your eyes open. ',
  'Let the person drag you', "move", 1, 'y',
  'Try to get loose', "info", 'Your attempt is weak, and the anonymous dragger barely has to resist it.', '',
  " ", "", '', "",
  " ", '', '', '',
  " ", '', '', ''),

  new room(2, 0, 2,'You wake up once again. This time chained to a chair in a dungeon cell. In the echoes of the stone walls you hear a faint sound of two people talking to eachother.' ,
  'Wait' , "move"  , 1, 'y',
  'Listen' , "info"  , 'They seem to be talking about you. Something about the fact that your "papers" are good. The conversation puzzles you.', '',
  " " , "" , '' , '' ,
  " " , "" ,  '', '' ,
  " " , "" ,  '', '' ) ,

  new room(3, 0, 3,'A woman walks up to your cell. The iron hinges screech as she treads in and sits by a chair. She is wearing a loose brown robe. On a chain necklace there is some sort of round iron symbol with a cross over it. She greets you and asks if you feel ready to answer some questions.' ,
  'Yes' , "move"  , 1, 'y',
  'No' , "move"  , -1, 'x',
  " " , "" , '' , '' ,
  " " , "" ,  '', '' ,
  " " , "" ,  '', '' ) ,


      new room(4, -1, 3,'The woman sits quietly and waits for a couple of minutes.' ,
      'I am ready now.' , "move"  , 1, 'xy',
      'Wait' , "info"  , 'You wait a bit longer to get ready.', '',
      " " , "" , '' , '' ,
      " " , "" ,  '', '' ,
      " " , "" ,  '', '' ) ,


  new room(5, 0, 4,'"Wonderful, let us begin then." She lifts a scroll from her backpack beside her and unravels it. "I will present 3 questions. Answer truthfully and you will soon be out of here. Understood?"' ,
  'No' , "move"  , -1, 'x',
  'Yes' , "move"  , 1, 'y',
  " " , "" , '' , '' ,
  " " , "" ,  '', '' ,
  " " , "" ,  '', '' ) ,

      new room(6, -1, 4,'The woman takes a deep breath and restates her question, this time with three fingers in the air and the voice similar to how you would explain something to a small child. "I will ask you 3 questions, do you understand?"' ,
      'Yes' , "move"  , 1, 'xy',
      " " , ""  , '', "",
      " " , "" , '' , '' ,
      " " , "" ,  '', '' ,
      " " , "" ,  '', '' ) ,

  new room(7, 0, 5,'Suddenly the woman says you have completed the test and can now follow her out of the cell. She opens the iron gate and takes you up the stairs of the dungeon. BÄTTRE TRANSITIONIt seems this place has not been properly maintained for a while. The air reeks of rot and the uneven steps are covered in cracks and dust. Upon reaching the top of the spiral staircase you enter a large hall. On a withered throne sits a man with his face down and a crown on his head. The robed woman leads you up to the man, who looks up at you as you reach the foot of the stairs leading up to the throne.' ,
  'Bow' , "move"  , 1, 'y', //borde fixas till ett stat
  'Stand' , "move"  , 1, 'y',//samma
  " " , "" , '' , '' ,
  " " , "" ,  '', '' ,
  " " , "" ,  '', '' ) ,

  new room(8, 0, 6,'"Welcome to my kingdom...if I can call it that anymore. I am the ruler of this pile of rubble, the last stronghold of the old world. It is at a late and dark hour that you arrive, but if my priest brings you here there is still hope." The king pauses. ' ,
  '...' , "move"  , 1, 'y', //borde fixas till ett stat
  " " , ""  , '', '',//samma
  " " , "" , '' , '' ,
  " " , "" ,  '', '' ,
  " " , "" ,  '', '' ) ,

  new room(9, 0, 7,' "Long ago we lived in harmony. I was king in a great empire and ruled for many thousands of years in a prosperous and healthy kingdom. Held up the great Scholars of the Old Capitol, it was a land where knowledge and creative expression bloomed!. Then, one day many moons ago, a mysterious force grabbed ahold of the world, and did not let go. Its grasp is still iron tight to this day, slowly corrupting the ground on which you stand." ' ,
  'Ask why you are here.' , "move"  , 1, 'y', //borde fixas till ett stat
  "Stay silent." , "move"  , 1, 'y',//samma
  " " , "" , '' , '' ,
  " " , "" ,  '', '' ,
  " ", "" ,  '', '' ) ,

  new room(10, 0, 8,' "It was foretold that the saviour of our land would come to us, arising from the salt and seafoam of the sea. A chosen one, a traveller who would take on the fight which we are too powerless to face ourselves. This traveller would arrive at my keep and set out to climb the great mountain and defeat the evil that lurks beneath. My priest tells me she has confirmed that this chosen one now stands before me. There is no time to waste, you should get on as soon as you can with this great task of yours. Will you accept this quest?' ,
  "Yes" , "move"  , 1, 'y',
  "No" , "tp"  , 1, 8,
  " " , "" , '' , '' ,
  " " , "" ,  '', '' ,
  " ", "" ,  '', '' ) ,
    // end 1
      new room(11, 1, 8,' "Are you sure? The fate of the world lies in your hands, if you do not help us this might well be the end. Will you not help us?"  ' ,
      "Reconsider (accept).", "tp"  , 0, 9,
      "Decline" , "tp"  , 2, 8,
      " " , "" , '' , '' ,
      " " , "" ,  '', '' ,
      " ", "" ,  '', '' ) ,

      new room(12, 2, 8,' The King looks at you, emptiness in his eyes. Awkwardly, you shuffle out of the room, make your way out of the castle and go back where you came from: The Sea.' ,
      "..." , "tp"  , 3, 8,
      "" , ""  , '', '',
      " " , "" , '' , '' ,
      " " , "" ,  '', '' ,
      " ", "" ,  '', '' ) ,

      new room(13, 3, 8,' A week later, your drowned body is found, half-eaten by seagulls, floating down lake Malar in central Stockholm. ' ,
      "try again" , "tp"  , 0, 0,
      "exit" , "tp"  , 4, 8,
      " " , "" , '' , '' ,
      " " , "" ,  '', '' ,
      " ", "" ,  '', '' ) ,


      new room(14, 4, 8,' You decide you are happy with how your journey has ended and exit this game.  ' ,
      "..." , "tp"  , 5, 8,
      " " , ""  , '', '',
      " " , "" , '' , '' ,
      " " , "" ,  '', '' ,
      " ", "" ,  '', '' ) ,

      new room(15, 5, 8,' Well I guess close the browser or something... Go and do something productive maybe, well I mean if you are too lazy to even accept a fictional quest in a game you probably won\'t do anything productive now will you.' ,
      "..." , "tp"  , -1, 1337,
      " " , ""  , '', '',
      " " , "" , '' , '' ,
      " " , "" ,  '', '' ,
      " ", "" ,  '', '' ) ,
    // -end 1


  new room(16, 0, 9,' The King is delighted, jumping up and down with joy. "You have my thanks, traveller. Now head on down to the courtyard of this castle to recieve the supplies you will need for your journey!" ' ,
  "Go to the courtyard" , "tp"  , 0, 10,
  " " , ""  , '', '',
  " " , "" , '' , '' ,
  " " , "" ,  '', '' ,
  " ", "" ,  '', '' ) ,

  new room(17, 0, 10,' The halls and rooms of the great castle impress you as you pass them, but you cannot help but feel their glory days are long gone. It seems the King really is in grave need of your help. A tall, handsome man with freakishly good posture quickly walks up to meet you in the courtyard. Behind him, in a dark corner, stands a Giant, who is absentmindedly kicking around a large boulder with some advanced martial moves. The handsome man shakes your hand enthusiastically and smiles:' ,
  "..." , "tp"  , 0, 11,
  " " , ""  , '', '',
  " " , "" , '' , '' ,
  " " , "" ,  '', '' ,
  " ", "" ,  '', '' ) ,

  new room(18, 0, 11,' "G\'day, mate! So you\'re this famous traveller I\'s been hearin\' about, aye? Fair dinkum! Me myself, I\'m the guy that\'s runnin\' things around this \'ere facility. \'Cept for his kingship, a\'course! Name\'s Sir Rarren Wussle and I reckon I\'ll be tellin\' ya the gist a things around here. Whaddaya wanna know, aye?" ' ,
  ' "What\'s this all about? Where am I?" ' , "info"  , ' "This here\'s the Highlands. We\'ve got mighty big fields and not lotsa trees. Unfortunately, for ya, especially if ya happen t\'be a bludger, is this is the farthest place in the world from where you\'re s\'pposed to go. Good for us, though, aye? Less corruption from that strange force!" ', '',
  ' "What am I to do on this quest?" ', "info"  , '  "Oh, it\'ll be hard yakka for ya, mate! You\'ve got yourself a long way to go. First you\'ll pass through these \'ere Highlands, then trudge through one helluva swamp. Smells a bit like chunder, but it\'s alright. It\'s named the Bog for a reason, mate, lemme tell ya, big pile o\' dung that is! Anyway, after that, you\'ll be passin\' through a town. That town\'s a bummer, for sure. Hear some sort of winged mozzies have took it now, hell do I know, I\'ve just been chillin\' right here all this time, aye! After that you\'ll wanna climb up the mountain above that town, and after that... well, God help ya mate!" ', '',
  ' "Who\'s that giant in the back?" ' , "info" , ' "Oh, that\'s Tadreus Ampe. Friend of mine. Real handsome bloke, corruption made him grow to a big fella\' but he\'s still a real kicka\'! " ' , '' ,
  ' "Where do I go from here? (continue to next area)" ' , "tp" ,  0, 12 ,
  " ", "" ,  '', '' ) ,


  new room(19, 0, 12,' "This road right here leads to a small village ahead. Head on down and ye\'ll be well on your way! Go on!" ' ,
  "Enter The Higlands" , "tp"  , 0, 20, //fixa typ som  ändrar färger, titel och bild.
  " " , ""  , '', '',
  " " , "" , '' , '' ,
  " " , "" ,  '', '' ,
  " ", "" ,  '', '' ) ,

  new room(20, 0, 20,' As the castle gate lowers behind you and you start down the road, you look around. Hills stretch below a blue sky, and a few hundred yards away, you see smoke rising from a couple crooked chimneys. Far away in the distance, ominous clouds loom high above a dark swamp. A man in a well-worn yellow jacket sits hunched over a map by the side of the road. He is mumbling to himself. ' ,
  "Approach the man." , "tp"  , 1, 20,
  "Keep walking." , "tp"  , 0, 21,
  " " , "" , '' , '' ,
  " " , "" ,  '', '' ,
  " ", "" ,  '', '' ) ,

      new room(21, 1, 20, 'You walk toward the man. As you get closer, he looks up from his map and a smile stretches from his left ear to his right. Eyes shining, he says: "Hello, traveler. My name is Yuel and I... I seem to be lost. Do you think you could help me? I was supposed to take a message from a fellow down in the village over yonder, but I can\'t find my way out of these Highlands. Do you think you could carry the message for me?"' ,
      ' "Okay. That\'s where I was going anyway."' , "tp"  , 2, 20,
      ' No, sorry" ' , "tp"  , 1, 21,
      " " , "" , '' , '' ,
      " " , "" ,  '', '' ,
      " ", "" ,  '', '' ) ,


          new room(22, 2, 20,' "Oh, praise be unto you, traveler! This is really a great relief! The message is to be delivered to lady wearing a pink gown who lives in the swamp. You can\'t miss her. Thanks again, traveler."" You smile uncomfortably and turn away from Yuel. He walks back to his rock. You walk down the road. ' ,
          "..." , "tp"  , 0, 21,
          " " , ""  , '', '',
          " " , "" , '' , '' ,
          " " , "" ,  '', '' ,
          " ", "" ,  '', '' ) ,

      new room(23, 1, 21,' "Oh, well sorry to bother you, traveler.", Yuel says, returning to his rock. As you continue down the road, the sound of his mumbling fades.' ,
      "..." , "tp"  , 0, 21,
      " " , ""  , '', '',
      " " , "" , '' , '' ,
      " " , "" ,  '', '' ,
      " ", "" ,  '', '' ) ,


  new room(24, 0, 21,' The side of the road is littered with small cottages. Children are laughing and playing in the gardens. There\'s a dog barking but you cannot see it. You trudge down the road until you come to a crossroads. You glance to the right and see the village you spotted from the castle. To the left, the road continues towards the mountain where you are to go. However, the bridge over a river, dividing the Highlands and the Bog, is broken.' ,
  "Go to the village. " , "tp"  , 0, 22,
  "Go to the river. " , "tp"  , 1, 21,
  " " , "" , '' , '' ,
  " " , "" ,  '', '' ,
  " ", "" ,  '', '' ) ,

    new room(25, 1, 21,' As you approach the river you realise it is much wider than you previously thought. The stream looks violent up close. The odds of making it across are not in your favour. Downstream, the water clashes against spiky rocks. ' ,
    "Go back" , "tp"  , -1, 21,
    "Swim across." , "tp"  ,'' ,'' ,
    " " , "" , '' , '' ,
    " " , "" ,  '', '' ,
    " ", "" ,  '', '' ) ,

  new room(26, -1, 21,' Back at the crossroads. That river was to scary!' ,
  "Go to the village. " , "tp"  , 0, 22,
  " " , ""  , '', '',
  " " , "" , '' , '' ,
  " " , "" ,  '', '' ,
  " ", "" ,  '', '' ) ,

  new room(27, -2 , 21,' You return to the crossroads. Nothing has changed.' ,
  "Go to the village. " , "tp"  , 0, 22,
  "Go to the river" , "tp"  , 1, 21,
  " " , "" , '' , '' ,
  " " , "" ,  '', '' ,
  " ", "" ,  '', '' ) ,

  new room(28, -3 , 21,' You return to the crossroads. The river seems calmer now.' ,
  "Go to the river" , "tp"  , 1, -21, // kanske åka till en version som inte är lika svår
  " " , ""  , '', '',
  " " , "" , '' , '' ,
  " " , "" ,  '', '' ,
  " ", "" ,  '', '' ) ,

    new room(29, 1, -21,' As you approach the river you realise it is much wider than you previously thought. However the stream does not look too violent. You could probably swim across. Downstream, the water clashes against spiky rocks. ' ,
    "Go back" , "info"  , 'You want to go back but realize you have a mission to complete, and "back" is the wrong direction', '',
    "Swim across." , "tp"  , 4 ,21 ,
    " " , "" , '' , '' ,
    " " , "" ,  '', '' ,
    " ", "" ,  '', '' ) ,

    new room(30, 4, 21,' You take one or two deep breaths, and then set a foot in the river. It is much deeper than you imagined, and suddenly, you find yourself entirely submerged in the water. ' ,
    "..." , "encounter"  , 'flappy_river', '',//RIVER GAME Low difficulty
    " " , ""  , '', '',
    " " , "" , '' , '' ,
    " " , "" ,  '', '' ,
    " ", "" ,  '', '' ) ,



    new room(31, 2, 21,' "If I\'m to complete this quest, I need to prove myself physically!" You take one or two deep breaths, and then set a foot in the river. It is much deeper than you imagined, and suddenly, you find yourself entirely submerged in the water. ' ,
    "..." , "encounter"  , 'flappy_river', fr_hard,//RIVER GAME MAX DIFFICULTY lägg till info om att man klarar den så kan man inte komma tillbaka (men man kan välja att inte spela om)
    " " , ""  , '', '',
    " " , "" , '' , '' ,
    " " , "" ,  '', '' ,
    " ", "" ,  '', '' ) ,
    //rivergame failed
    new room(32, 3, 21,' YOU LOSE CONTROL! The current is overpowering, and you feel as though a giant was forcing you downstream with all his might and power. In a last ditch effort to save your soul, you grab onto a rock as it passes. Using every ounce of effort in your body, you hurl yourself onto it. You lay on the rock, catching your breath, for a very long time. An hour passes. You pull yourself up, and stand on the rock. From here you realize you can jump across, back to the shore, back to safety. You take the leap, and lay down in the green pastures and rest. With heavy breaths you drag yourself back to the crossroads.' ,
    "..." , "tp"  , -1, 22,
    " " , ""  , '', '',
    " " , "" , '' , '' ,
    " " , "" ,  '', '' ,
    " ", "" ,  '', '' ) ,
    //rivergame complete
    new room(33, 5, 21,' You have made it safely to the other side and hurl yourself onto the mushy soil. A hundred yards down the road, a wall stretches, as far as your eyes can see. Directly ahead, is a closed gate, and a man sits in front of it on a stool, tapping his foot slowly on the ground. ' ,
    "Go to the gate." , "tp"  , 0, 30,
    "Go back across the river" , "info"  , 'You want to swim back, but realize you have a quest to complete!', '',
    " " , "" , '' , '' ,
    " " , "" ,  '', '' ,
    " ", "" ,  '', '' ) ,


  new room(34, 0, 22,' The village looks nice. You go there. Meandering down the road, a horse carriage passes you, and you hear laughing from inside. Together with the rhytmic click-clack of the horses hooves, the laughing melts together with the roaring guffaws reaching you from the town tavern. It is getting late. And the sun is setting.' ,
  "..." , "tp"  , 0, 23,
  " " , ""  , '', '',
  " " , "" , '' , '' ,
  " " , "" ,  '', '' ,
  " ", "" ,  '', '' ) ,

  new room(35, 0, 23,' Suddenly, you find yourself in the town square. Surrounded by merchants dismantling their stands, you look around: Infront of you is the tavern you saw before. Shadows dance in its inviting orange light. To your left there is a house with its front closed. The lights seem to be off. To your right is the uneven path leading back to the crossroads.' ,
  "Go forward." , "tp"  , 1, 22,
  "Go left " , "info"  ,"You go to the house and knock on the door. Nobody answers." , '',
  "Go right (return to crossroads)" , "tp" , -2 , 21 ,
  " " , "" ,  '', '' ,
  " ", "" ,  '', '' ) ,



    new room(36, 1, 22,' The sun is setting now. When you put your weight into the heavy wooden entrance to the tavern, it squeaks open. Inside, large men laugh around small tables. There is a pungent smell of lukewarm beer. In the corner, a hooded man is smoking a large pipe. ' ,
    "..." , "tp"  , 2, 22,
    " " , ""  , '', '',
    " " , "" , '' , '' ,
    " " , "" ,  '', '' ,
    " ", "" ,  '', '' ) ,

    new room(37, 2, 22,' The bartender gives you a look as you enter, and then goes back to cleaning an old beer mug. An inviting bowl of steaming bread, labeled "TAKE ONE", sits on the bar. You take a piece of bread. It\'s beyond delicious. Your stomach growls for a second one, but you have no money. You eye the bowl... You eye the bartender...' ,
    "Take a piece of bread." , ""  , '', '', //encounter
    "Move on." , "tp"  ,3 , 22,
    " " , "" , '' , '' ,
    " " , "" ,  '', '' ,
    " ", "" ,  '', '' ) ,
    //encounter completed
      new room('Inn2.1', -2, 22,' "You feel full. Congratulations."' ,
      "..." , "tp"  , 3, 22,
      " " , ""  ,'' , '',
      " " , "" , '' , '' ,
      " " , "" ,  '', '' ,
      " ", "" ,  '', '' ) ,

    new room(38, 3, 22,' You continue on into the bar. On an empty table, a book is left curiously opened. You pick up the book. The title is "The Final Hours of Joshua Ngatu". The back of the book has two lines of text on it: "Property of the Library of the Capitol". Under that, there is a single word in bold, upper-case letters: "NON-FICTION". ' ,
    "Read an excerpt" , "tp"  , 3, -22,
    "Put the book down" , "tp"  ,4 , 22,
    " " , "" , '' , '' ,
    " " , "" ,  '', '' ,
    " ", "" ,  '', '' ) ,

      new room(39, 3, -22,' The Final Hours of Joshua Ngatu. Chapter 6.' ,
      "Flip page." , "tp"  , 4, -22,
      "Put the book down" , "tp"  ,4 , 22,
      " " , "" , '' , '' ,
      " " , "" ,  '', '' ,
      " ", "" ,  '', '' ) ,
      new room(40, 4, -22,'"I tore out the last few pages. After waking up no more than a half an hour ago, I read them aloud to myself in the light of my second to last candle. It was incoherent nonsense and you, dear reader, should be thankful you do not have to trek through such ramblings. At any rate, I am, as I said, on my second to last candle now. The light is fading and I know that I will soon have to use my final candle as well. By the time the flame of the final candle is snuffed, I am quite sure that the red circle will have killed me nonetheless, and so, my days will come to an end."' ,
      "Flip page." , "tp"  , 5, -22,
      "Put the book down" , "tp"  ,4 , 22,
      " " , "" , '' , '' ,
      " " , "" ,  '', '' ,
      " ", "" ,  '', '' ) ,
      new room(41, 5, -22,'"I can feel it burrowing deeper. I can feel it scratching and clawing behind my eyeballs, heading, no doubt, toward my brain. I wonder if this is how all the others felt in their final moments. I should not say all the others. I know for a fact there are still a handful remaining groups. A family or two. Although, -and I do pray you will forgive my cynicism when I say this- they have not long to go. Soon, the children will not be strong enough to stand on their own two legs. Really, who could? With all that constant oppressive noise I know I would without a doubt be unable to. In fact, that is why I escaped to this cave. I could not have beared that indescribably horrendous buzzing any longer, or I would\'ve gone mad."' ,
      "Flip page." , "tp"  , 6, -22,
      "Put the book down" , "tp"  ,4 , 22,
      " " , "" , '' , '' ,
      " " , "" ,  '', '' ,
      " ", "" ,  '', '' ) ,
      new room(42, 6, -22,' "Or, well... I should not lie to you, precious reader. I have already gone mad. Quite insane, indeed. But it is to be expected. You see, I did look into the eyes of the King after all, and it is commonly known among all those of us who remain that the poor sods who look into the eyes of the King when he is not in disguise, those who lay eyes on his true form, they will inevitably retreat into some rancid, dank corner of the earth and rip their hair and guts out in a pandaemonium of the soul. And now I am only waiting..."                The following pages are empty or torn out.' ,
      "Put the book down." , "tp"  , 4, 22,
      " " , ""  ,'' , '',
      " " , "" , '' , '' ,
      " " , "" ,  '', '' ,
      " ", "" ,  '', '' ) ,

  new room(43, 4, 22,' You walk further into the room. As you pass a table balancing on crooked legs, a man wearing a large fur violently grabs onto your arm. "Oi, time for a card game?! I\'ll give ya a good price if you win!" ' ,
  "Respectfully tell him no" , "tp"  , 5, 22,
  "Ask about the price." , "info"  ,"You\'ll just have to win and see!" , 22,
  "Accept the invitation." , "tp" , -5 , -22 ,
  "Accept the invitation enthusiastically." , "tp" ,  -5, -22 ,
  " ", "" ,  '', '' ) ,

    new room(44, -5, -22,' The GAMBLER smacks you on the shoulder and his bellowing laugh makes the entire bar turn around to look at you for a second. You can\'t help but smile. The man informs that you are to play the classic card game Attack and Defend, and that you will have the role of the defender. He then gives you a crossbow.' ,
    "..." , "encounter"  , 'card_game', '',//encounter
    " " , ""  , '', '',
    " " , "" , '' , '' ,
    " " , "" ,  '', '' ,
    " ", "" ,  '', '' ) ,



    new room(45, -6, -22,'  "Well played defender! That was a good bout. As a reward I\'ll let you keep the crossbow! Good luck with whatever it is you are doing!" The man brings up another item from a big bag behind his table, and grabs another passing fellow, whereafter he seems to be proposing another, completely different game. Crossbow added to your inventory.' ,
    "Keep looking around in the bar." , "tp"  , 5, 22,
    " " , ""  , '', '',
    " " , "" , '' , '' ,
    " " , "" ,  '', '' ,
    " ", "" ,  '', '' ) ,

    new room(46, -7, -22,' You decide that whatever price this lunatic has to offer is not worth it and admit defeat. ' ,
    "Keep looking around in the bar." , "tp"  , 5, 22,
    " " , ""  , '', '',
    " " , "" , '' , '' ,
    " " , "" ,  '', '' ,
    " ", "" ,  '', '' ) ,

new room(47, 5, 22,'You move into a corner of the bar. And you sit down at an empty table, rest your legs. You untie your boots, letting your aching feet breathe. A moment of silence is quickly abrupted by a woman tumbling down in the seat in front of you. She is wearing a thick sweater, despite the hot weather.' ,
'Ask the woman who she is.' , "tp"  , 6, 22,
'Kindly ask her to leave.' , "tp"  , -5, 22,
" " , "" , '' , '' ,
" " , "" ,  '', '' ,
" ", "" ,  '', '' ) ,

  new room(48, -5, 22,'The woman looks at you. After an incredibly awkward minute, she gets up and leaves. A second later, a girl wearing a white apron appears beside you. "You want anything?", she asks. ' ,
  'Beer.' , "tp"  , -6, 22,
  'Soup' , "tp"  , -6, 22,
  "Orange juice" , "tp" , -6 , 22 ,
  " " , "" ,  '', '' ,
  " ", "" ,  '', '' ) ,

  new room(49, -6, 22,'You finish your drink and leave, feeling rested.' ,
  'Return to the town square.' , "tp"  , -7, 22,
  ' ' , ""  , '', '',
  " " , "" , '' , '' ,
  " " , "" ,  '', '' ,
  " ", "" ,  '', '' ) ,

    new room(50, -7, 22,'Back in the town square. Infront of you is the tavern. No longer open. To your right is the uneven path leading back to the crossroads.' ,
    'Go back to the crossroads.' , "tp"  , -3, 21,
    " ", ""  , '', '',
    " " , "" , '' , '' ,
    " " , "" ,  '', '' ,
    " ", "" ,  '', '' ) ,

new room(51, 6, 22,'The woman smiles from ear to ear. "I\'m Nanette.", she says. "You look tired." You don\'t answer, look around at the bar\'s occupants sitting around you. At the next table to the left, a young man and woman sit opposite one another, both looking into their laps. The phrase break-up flashes through your mind. Yeesh. Nanette speaks again: "I gave my letter to another traveler early this morning. Have you met him on the road?"' ,
'"Yuel?"' , "tp"  , 7, 22,
'"No sorry"' , "tp"  , -5, 22,// måste kolla om spelaren har brevet
" " , "" , '' , '' ,
" " , "" ,  '', '' ,
" ", "" ,  '', '' ) ,

new room(52, 7, 22,'"Yes! Yes! Did you see him?"' ,
'"He said he was taking the letter to the swamp."' , "tp"  , 8, 22,
" " , ""  , '', '',
" " , "" , '' , '' ,
" " , "" ,  '', '' ,
" ", "" ,  '', '' ) ,

new room(53, 8, 22,'"Indeed, that is what I told him" Nanette smiles.' ,
'"Well, I met hin over by the caste."' , "tp"  , 9, 22,
" " , ""  , '', '',
" " , "" , '' , '' ,
" " , "" ,  '', '' ,
" ", "" ,  '', '' ) ,

new room(54, 9, 22,'Nanette laughs in disbelief "By Jingo, the man went in the completely wrong direction! Was he holding the map upside down?"' ,
'"Likely, yes. I have the letter now, though. He gave it to me."' , "tp"  , 10, 22,
" " , ""  , '', '',
" " , "" , '' , '' ,
" " , "" ,  '', '' ,
" ", "" ,  '', '' ) ,


new room(55, 10, 22,'"Oh... Okay, well, I guess then I\'ll have to tell you how to get into the swamp. The Bog, they call it. The gate to cross into it is guarded by an armored man known as Stephen of the Kelts. He used to be a kind man a long time ago, but then something happened, and suddenly he just sits there by the gate... watching. He doesn\'t let anyone through. I\'ve gone over to him every day, figurin\' he\'s gotta be hungry... So I give him an egg sandwich, and as he gulfs it down, I recognise a tiny bit of that ol\' kindness in his eyes."' ,
'"What happened to him?"' , "tp"  , 11, 22,
" " , ""  , '', '',
" " , "" , '' , '' ,
" " , "" ,  '', '' ,
" ", "" ,  '', '' ) ,

new room(56, 11, 22,'"No one knows. Come to think of it, I haven\'t given him his egg sandwich today. If you give it to him, he might let you through." Nanette gives you an EGG SANDWICH. You put it in your pocket. Nanette stands up. "Go on.", she says. "That letter has to get there fast. Good luck, wherever your travels take you."' ,
'Leave the bar.' , "tp"  , -7, 22,
"Sit and wait for a couple of minutes." , "info"  , 'You sit and wait a while longer. Nanette stands there looking over you. You feel uncomfortable.', '',
" " , "" , '' , '' ,
" " , "" ,  '', '' ,
" ", "" ,  '', '' ) ,



//STEPHEN BOSS BATTLE
new room(57, 0, 30,' ' ,
" " , ""  , '', '',
" " , ""  , '', '',
" " , "" , '' , '' ,
" " , "" ,  '', '' ,
" ", "" ,  '', '' ) ,


new room(58, 0, 31,'Finally being able to walk through the guarded gate, a murky land lay before you. Overgrown trees hang over the muddy ponds and a small road lingers forward into the dark swamp.' ,
"Enter The Bog." , "tp"  , 0, 32,
" " , ""  , '', '',
" " , "" , '' , '' ,
" " , "" ,  '', '' ,
" ", "" ,  '', '' ) ,

new room(59, 0, 32,'Slowly making your way across the worn road you arrive at a crossing. Ahead there is an old sign pointing in the direction of the main road. To the east there is, what seems to be an even older road, obstructed by a fallen tree. Beside the old road, a round sign with some markings you cannot make out from this distance. To your left there a body of water that leads on into the forest to the west, and a trail that goes alongside it. Underneath the sign sits a woman dressed in pink garb. ' ,
"Keep moving north." , "tp"  , 0, 33,
"Investigate the sign." , "tp"  , 1, 32,
"Move down the path along the water." , "tp" , -1 , 33 ,
"Talk to the woman." , "tp" ,  0, -32,
" ", "" ,  '', '' ) ,

  new room(60, -1, 33,'The path along the water looks most inviting. You tiptoe along the edge of the water and hear the bugs and creatures buzz around in the bushes around you. It’s somewhat peaceful for a moment... At points along the river, the sun shines through the dense forestry and casts beautiful rays of light on the bright green algae. The peace ends when you notice a woman sitting, crouched on the shore, making buzzing noises.' ,
  "Approach the woman." , "tp"  , -2, 33,
  "Sneak past the woman." , "tp"  , -12, 33,
  " " , " " , '' , '' ,
  " " , " " ,  '', '',
  " ", "" ,  '', '' ) ,
    new room(61, -2, 33,'You call out a greeting. The woman looks up, pulled out of her buzzing world. She smiles a devious smile. "Hello", she says. "I am Canelia".' ,
    'Ask the woman what she is doing here.' , "tp"  , -3, 33,
    'Tell the woman to elaborate.'  , "tp", -3, -33,
    " " , " " , '' , '' ,
    " " , " " ,  '', '',
    " ", "" ,  '', '' ) ,
    new room(62, -3, 33,'"I could ask you the same thing! Why are you even here? You don\'t look like a bug."' ,
    '"What?"' , "tp"  , -4, 33,
    ' '  , ' ', ' ', '',
    " " , " " , '' , '' ,
    " " , " " ,  '', '',
    " ", "" ,  '', '' ) ,
    new room(63, -4, 33,'" Except for the Old Hag downriver, only bugs live here, in case you didn\'t notice... You\'ve now approached Canelia and are standing next to her. She stands up and looks you over from head to toe."' ,
    '...' , "tp"  , -5, 33,
    ' '  , ' ', ' ', '',
    " " , " " , '' , '' ,
    " " , " " ,  '', '',
    " ", "" ,  '', '' ) ,
    new room(64, -5, 33,'She knocks a bit on your head "Gregor Helloo!"... "Nope. Not a bug. Definitely." You eye her, and consider if the woman is insane. There is an awkward silence for a few seconds.' ,
    '...' , "tp"  , -6, 33,
    ' '  , ' ', ' ', '',
    " " , " " , '' , '' ,
    " " , " " ,  '', '',
    " ", "" ,  '', '' ) ,
    new room(65, -6, 33,'"Gotcha! Ha ha ha ha ha. Oh, you should have SEEN your damn face!" Somehow, this is your strangest encounter yet.' ,
    '...' , "tp"  , -7, 33,
    ' '  , ' ', ' ', '',
    " " , " " , '' , '' ,
    " " , " " ,  '', '',
    " ", "" ,  '', '' ) ,
    new room(66, -7, 33,'I\'m just kidding! I\'ve been waiting for two hours for someone to walk by... Oh, oh, lord your damn face! Oh... What are you doing here anyway? These are dark parts. There have been strange on-goings here for a while, I\'ll tell you that. Some people passing through have been acting fuzzy. Like they’re possessed. It’s horrible. People who used to be kind have turned... well, not kind.' ,
    'Ask the woman if she is feeling okay.' , "tp"  , -8, 33,
    'Ask if there is anything down the river.'  , "tp", -9, 33,
    " " , " " , '' , '' ,
    " " , " " ,  '', '',
    " ", "" ,  '', '' ) ,

    new room(67, -8, 33,'Okay? Okay? I\'m great! Anyway... I really don\'t have much time now after spending two hours at this river, I\'ve got a lot to do... really. I don\'t know if I\'ll have time for all of it... we\'ll see. Anyway! See you around, maybe! Canelia disappears into the brush and bramble. You turn back toward the path. But a second later, you here commotion in the bushes. Suddenly, a small, round device hits you in the back of the head.' ,
    '...' , "tp"  , -10, 33,
    " "  , "", '', '',
    " " , " " , '' , '' ,
    " " , " " ,  '', '',
    " ", "" ,  '', '' ) ,
    new room(68, -9, 33,'Oh just that old lady doing lord knows what. Don\'t seem to be hurting anybody, but not really doing any good either. Just wasting peoples time pretty much! Anyway... I really don\'t have much time now after spending two hours at this river, I\'ve got a lot to do... really. I don\'t know if I\'ll have time for all of it... we\'ll see. Anyway! See you around, maybe! Canelia disappears into the brush and bramble. You turn back toward the path. But a second later, you here commotion in the bushes. Suddenly, a small, round device hits you in the back of the head. ' ,
    '...' , "tp"  , -10, 33,
    " "  , "", '', '',
    " " , " " , '' , '' ,
    " " , " " ,  '', '',
    " ", "" ,  '', '' ) ,
    new room(69, -10, 33,'"In case you meet real, actual bugs on your travels!"' ,
    'Put the device in your pocket.' , "tp"  , -11, 33,//inventory
    "Leave the device."  , "tp",-13 ,33,
    " " , " " , '' , '' ,
    " " , " " ,  '', '',
    " ", "" ,  '', '' ) ,
    new room(70, -11, 33,'"You put the device in your pocket and continue further up the river."' ,
    '...' , "tp"  , -13, 33,//inventory
    " "  , " ",'' ,'',
    " " , " " , '' , '' ,
    " " , " " ,  '', '',
    " ", "" ,  '', '' ) ,
    new room(71, -12, 33,'The stones along the bank are slippery, but carefully, methodically, you continue without falling. Soon enough, the woman is far behind you.' ,
    'Keep moving up the river.'  , "tp", -13 , 33,
    " " , " " , '' , '' ,
    " " , " " ,  '', '',
    " ", "" ,  '', '' ) ,

    new room(72, -13, 33,'Further down, the river ends in a waterfall. You climb down the edge where it falls and notice a small, tilted, wooden shack behind the waterfall. A charmingly beguiling orange-yellow light shines from the inside. From a its chimney rises a think smoke that smells like a wonderful blend of parsley, sage, rosemary and thyme.' ,
    'Enter the house.' , "tp"  , -15, 33,
    'Turn back.'  , "tp",-14 ,33,
    " " , " " , '' , '' ,
    " " , " " ,  '', '',
    " ", "" ,  '', '' ) ,
    new room(73, -14, 33,'You turn back, a gut feeling tells you that whatever you will meet in that shack is going to take too much time. Time you should be spending towards getting towards your goal.' ,
    '...' , "tp"  , -2, 32, //FIXA RUMMET
    " "  , " ", '' ,'',
    " " , " " , '' , '' ,
    " " , " " ,  '', '',
    " ", "" ,  '', '' ) ,
    new room(74, -15, 33,'The water grazes your hair as you walk through the edge of the waterfall. A film of dew coats your face. I\'s cold and rejuvenates your tired mind. You knock on the wooden door to the shack. It seems to be made of bark. There is an encryption on the door: "Inauguration inside. Welcome, traveler." No one has answered the door.' ,
    'Go inside.' , "tp"  , -16, 33,
    "Knock again."  , "info", 'You knock again. Still nobody answers the door.' ,'',
    " " , " " , '' , '' ,
    " " , " " ,  '', '',
    " ", "" ,  '', '' ) ,
    new room(75, -16, 33,'Inside, a woman in a long, red cloak sits on a tree stump remodeled as a chair. "Greetings", she croaks. Her voice is hoarse but warm. "Sit down at the table, traveler. Welcome to the Inauguration." There is a cauldron in the middle of the room. ' ,
    'Kindly explain that you stepped wrong and will be leaving now.' , "tp"  , -17, 33,
    "Sit down at the table."  , "tp", -17 ,33,
    " " , " " , '' , '' ,
    " " , " " ,  '', '',
    " ", "" ,  '', '' ) ,

    new room(76, -17, 33,'"My name is Cecilda of the Waterfall. I have been expecting you, traveler. You may not leave." You feel an invisible force pulling you toward the middle of the room, toward the cauldron. It bubbles and emits what a sound like an orchestra warming up for a symphony. How strange; suddenly, it seems like there is nothing you would want more than to lower your face into the colourful liquid. "Lower your head traveler, and see what visions appear. Until your visions are gone, my door remains closed."' ,
    'Lower your head.' , "tp"  , -19, 33,
    "Resist."  , "tp", -18,33,
    " " , " " , '' , '' ,
    " " , " " ,  '', '',
    " ", "" ,  '', '' ) ,

    new room(76, -18, 33,'You try to resist, but the pull is just too strong...' ,
    '...' , "tp"  , -20, 33,
    " "  , " ", '','',
    " " , " " , '' , '' ,
    " " , " " ,  '', '',
    " ", "" ,  '', '' ) ,

    new room(77, -19, 33,'You lower your head to see what lies beyond the window of liquid.' ,
    '...' , "tp"  , -20, 33,
    " "  , " ", '','',
    " " , " " , '' , '' ,
    " " , " " ,  '', '',
    " ", "" ,  '', '' ) ,
    new room(78, -20, 33,'Insert link and timer here lol' ,
    '...' , "tp"  , -20, 33,
    " "  , " ", '','',
    " " , " " , '' , '' ,
    " " , " " ,  '', '',
    " ", "" ,  '', '' ) , //insert stuff that happens when you return























  new room('template', -1, -1,' ' ,
  " " , ""  , '', '',
  " " , ""  , '', '',
  " " , "" , '' , '' ,
  " " , "" ,  '', '' ,
  " ", "" ,  '', '' ) ,



];
}
