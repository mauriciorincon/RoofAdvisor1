<?php

class customerFAQ{

    var $options_array= array("number_1","number_2","number_3","number_4","number_5","number_6","number_7","number_8");
    const number_1="1.	How much does a repair cost?";
    const number_2="2.	Repair Causes";
    const number_3="3.	Finding the Leak";
    const number_4="4.	Where Roof Leaks Are";
    const number_5="5.	Common Leaks & Repairs";
    const number_6="6.	Roof Repair Costs by Material Type";
    const number_7="7.	Common Roof Repairs & Their Costs";
    const number_8="8.	Conclusion";


    public function getArrayOptions(){
        return $this->options_array;
    }

    public function number_1(){
        return "<h1>How Much Does It Cost To Repair A Roof?</h1>
                    <p>National Average  <b>$845</b></p><br>
                    Typical Range <b>$455 - $1,435</b>
                    Low End <b>$220</b>
                    High End <b>$4,625</b>
                    <b>The national average roof repair cost is $845, with most homeowners spending $455 and $1,435.</b>
                    Maintaining a sound roof tops the list of crucial home repairs. It keeps your home interior warm and dry and protects it from the elements. Damage or signs of wear should call for immediate action to keep water from seeping in and rotting the wood sheathing beneath. Ignoring a problem, even what appears to be a small one, could result in eventually needing a new roof, which is not cheap. There are various repairs your roof might need, and it's important to keep an eye out for them and have repairs completed as quickly as possible.</p>
        ";
    }

    public function number_2(){
        return "<h1>Repair Causes</h1>
            <p>Most roof leaks are similar in nature and are due to the same types of problems. These include:
            <ul>
            <li>Blown off or missing shingles -- Regardless of the material they're made of, shingles are prone to lifting up due to high winds. Lighter materials suffer from this more than heavier ones, but even heavy asphalt shingles can peel up and blow away, leaving your underlayment and roof deck exposed to the elements.</li>
            <li>Bad or leaking pipe flashing -- The vent pipes on your roof sit underneath your roof material. They are usually well-sealed, but corrosion of the pipe flashing or of the sealant can allow water to seep through to the interior.</li>
            <li>Chimney/skylight step flashing -- Chimney flashing can leak if high winds pull it away from your chimney or roof, or if the sealant is compromised. Skylights are trickier to diagnose. What looks like a leak can just be condensation. However, a cracked skylight or worn seals can allow leaks to form.</li>
            <li>Valleys -- Valleys are the little gutters that run down interior angles on your roof. Flashing can be damaged by lifting tiles, fungus build up, or improper cleaning. Since the bulk of the rainwater is going to be channeled down these valleys by the laws of gravity, it's imperative to be sure they are not damaged.</li>
            <li>Ice dams -- Ice dams form when melted snow refreezes on your roof. This forms walls that don't allow other runoff to drain into your rain gutters or otherwise leave your roof.</li>
            <li>Low slope/inadequate roof pitch -- Low slope roofs are susceptible to wind damage almost as much as flat roofs. They also often don't provide good run-off in regions that see a lot of rain.</li>
        </ul>
        If you notice any of these signs, you should call a roofing specialist immediately to get the problem fixed.<br>
        Get a quote from a roofer now for your repairs.</p>
        ";
    }

    public function number_3(){
        return "<h1>Finding the Leak</h1>
        <p>Sometimes it's relatively easy for your contractor to find the leak because it is already leaking into your home. There are other leaks you might not see, but you can tell are there because of odor or damage to wood. On a flat roof, it's relatively easy to find leaks. On a sloped roof, sometimes it might take a bit more investigating to find the cause. Sometimes it may not be your roof that's leaking at all but the metal flashing around your chimney or vent pipes. Your gutters could also be causing the leaks.
        Be prepared to pay some labor costs for the inspection. Even if you think the leak is obvious, your contractor should do a thorough examination to ensure that there aren't more trouble spots. The average roofing labor cost by square foot varies based on location, season and contractor.</p>
        <h3>Quick Tip on Hunting for Roof Leaks</h3>
        <p>The biggest thing to remember about a leaking roof is that water flows downhill. Even flat roofs aren't truly flat. They have a small slope to them that lets water run to the drains. Depending on the slope of your roof, that mold or leak on your bedroom ceiling could originate at a trouble spot over your bedroom, or it could be originating further up the roof. If you're having trouble locating the leak, take a flashlight up into your attic space and look for dampness or mold. The sooner you can locate a leak, the less expensive it is to repair.</p>
        ";
    }

    public function number_4(){
        return "<h1>Where to Look for Roof Leaks</h1>
        <p>Though roofs come in many styles and are made of many different materials, they have common areas where leaks are more prone to happen. Here are the most common places to look:</p>
        <ul>
            <li><b>Flashing</b> -- The metal that connects vents and other ducting to your roof can age, corrode, and crack. It's probably the most common failure point on a roof. Plumbing vents have a rubber gasket that can deteriorate in 10 years. They should be inspected for cracking. B-vents are commonly used for gas appliances and often use a metal storm collar. The collar can work loose and allow leaks to occur. You can expect to pay $10-$20 for repairing these.</li>
            <li><b>Vertical Slits</b> -- The vertical slits between shingles is the most common place for this type of roof to have problems. Because water can run between them, they are more prone to corrosion, particularly in the top 3 inches. The usual repair is to replace the corroded tiles. Tiles usually sell by the bundle for about $30.</li>
            <li><b>Missing Granules</b> -- The stony surface of shingles helps protect the shingle itself from UV rays or from repeated walking on the roof. As they wear off from exposure, this can leave the shingle itself exposed. If you notice bare patches on your shingles, you can replace them before it becomes a problem for around $30 for a bundle of new shingles.</li>
            <li><b>Skylight</b> -- Skylights are beautiful additions to a home and allow plenty of natural daylight in, but they are also a major contributor to leaks. As water runs down a sloped roof, it hits the flat upper edge of your skylight and gets trapped there. Sometimes the window portion itself can get cracked. A $5 tube of clear silicone sealant can patch the window, but if the flashing is corroding from trapped water, replacing it can cost from $25 to $80.</li>
            <li><b>Valleys</b> -- The angles that are formed when two sloped roof panels come together perpendicularly are called valleys. They will naturally attract a lot of water during a good Rain. Shingles have to be cut to fit the shape of the valley and sometimes the cuts are rough. This can cause gaps that allow water under the shingles. Many people install flashing at the valleys. While this helps with uneven edges at the joint, the sealant should be routinely inspected as a preventative measure. Flashing for valleys costs around $20 for a 10' piece.</li>
            <li><b>Chimneys</b> -- The most common reason for leaks from your chimney is old caulking. However, don't just caulk it and walk away. Inspect the flashing for corrosion and cracking. If the caulking and flashing are fine, then the chimney itself may have fractures that are allowing water in behind the flashing. The flashing for a chimney costs around $20. Both flashing sealant and masonry caulk cost about $5 each.</li>
        </ul>
        ";
    }

    public function number_5(){
        return "<b>Common Roof Leaks, Repairs & Their Costs</b>
            <p>A leaking roof conjures up images of a house full of strategically placed buckets and helpless occupants in galoshes. The truth is that many leaks can be fixed by the homeowners. Here are some common leaks and what to do about them:</p>
            <table>
                <tr>
                    <td>Problem</td><td>Solution</td><td>DIY Cost</td>
                </tr>
                <tr>
                    <td>Cracked flashing -- Flashing is the metal strip that creates a water-resistant barrier between your roof joints. Due to age or extreme conditions, the metal can crack or corrode, or the tar used to seal it can deteriorate.
                    </td>
                    <td>Gently pry up the surrounding material, remove the old nails carefully, nail a new metal strip into place and reseal it with a little roofing tar.
                    </td>
                    <td>$20
                    </td>
                </tr>
                <tr>
                    <td>Broken or missing shingles -- High winds can lift up and break, or completely remove, shingles. You should be able to diagnose this by looking at your roof for off-color patches, or else by shingle debris in your yard after a storm
                    </td>
                    <td>If the shingle is broken, gently slide a pry bar under the broken shingle and lift until the nails holding it pop up. Press down on the broken shingle and gently remove the nails. Replace the shingle and nail it in place with four new nails.
                    </td>
                    <td>$30 unless you have really high-end shingles.
                    </td>
                </tr>
                <tr>
                    <td>Cracked vent booting -- Vent booting is a gasket used to seal your roof vents. A leak from this area will often leave dark spots and a musty odor
                    </td>
                    <td>Take a knife and cut away the old boot. Install the new boot over the vent and under the shingles. Secure it with roofing nails to either side and seal it with caulk.
                    </td>
                    <td>$10 to $20
                    </td>
                </tr>
                <tr>
                    <td>Ice dams -- These are caused by having a roof just warm enough to melt a little bit of the snow build-up. It quickly refreezes once it's away from the warmth and creates ice dams that hold snow on your roof. The weight of the ice can cause serious damage as well as the water pooling up.
                    </td>
                    <td>Buy a roof rake and remove the first four feet of snow from the roof's edge. If you see an icy build up (the ice dam), get some ice melt product (there are pet- and child-friendly types if that's a concern) and apply it per the manufacturer's directions. Then you can invest in a roof heat cable to prevent future ice dams.
                    </td>
                    <td>$50 to $70 (The rake is a one-time purchase of $30 to $50.)
                    </td>
                </tr>
                <tr>
                    <td>Skylight Leaks -- As well as trapping water (as mentioned above) skylight windows frames, and seals can crack as they age and form leaks. Before repairing, check to make sure your skylight isn't just forming normal condensation.
                    </td>
                    <td>Clean off any debris from your skylight and inspect or repair as needed for cracks. These can be repaired with clear silicone sealant. If the skylight is okay, check the flashing and repair as in \"Cracked flashing\" above.
                    </td>
                    <td>$25 to $80
                    </td>
                </tr>
                <tr>
                    <td>Clogged gutters -- Failure to clean your gutters can prevent rainwater from running off efficiently. This will allow water to pool up and find seams to leak through.
                    </td>
                    <td>The only way to fix this is to clean out your gutters.
                    </td>
                    <td>$0
                    </td>
                </tr>

            </table>
        ";
    }

    public function number_6(){
        return "<h1>Roof Repair Costs by Material Type</h1>
        </p>Roofs can be made from many different types of materials and designed in various styles. These include wood shake or composite roofing, asphalt shingles, metal, flat, foam or single ply roofing. You could also have a type of tile or slate roofing as well. The type of material and style that your roof is will dictate the cost. For example, shingle roofs are considered easy to repair while slate or tile roofs are among the most difficult.</p>
        <table>
            <tr>
                <td colspan=\"3\">Cost to Repair Roofing Problems</td>
            </tr>
            <tr>
                <td>Material</td><td>Common Problems</td><td>Average Cost to Fix</td>
            </tr>
            <tr>
                <td>Metal</td><td>leaks between panel fasteners, loose seams can let water through</td><td>$300</td>
            </tr>
            <tr>
                <td>Metal</td><td>leaks between panel fasteners, loose seams can let water through</td><td>$300</td>
            </tr>
            <tr>
                <td>Asphalt Shingles</td><td>strong storm winds can lift or remove shingles, loose nails can damage material</td><td>$250</td>
            </tr>
            <tr>
                <td>Composite</td><td>high winds can damage weak material, potential to lose entire sections, water can blow in between panels</td><td>$300</td>
            </tr>
            <tr>
                <td>Wood Shake</td><td>moss buildup, insect & UV damage (cedar is the exception)</td><td>$360</td>
            </tr>
            <tr>
                <td>Slate</td><td>leaks easily with improper installation, ice-damming</td><td>$530</td>
            </tr>
            <tr>
                <td>Tile</td><td>cracks or sliding, leaks, heat damage</td><td>$350</td>
            </tr>
            <tr>
                <td>Flat, Foam or Single-Ply</td><td>minor sags cause pools of water, pull up in high winds, improper sealing can cause leaks, mold growth</td><td>$400</td>
            </tr>
        </table>
        ";
    }

    public function number_7(){
        return "<h1>Other Common Roof Repairs and Costs</h1>
        <p>Anything that is exposed to the elements can suffer damage. Here are some areas that many people don't look at when inspecting their own roofs, but they should get the same attention as the roof itself.</p>
        <h3>Fascia and Soffits Repairs</3>
        <p>Often thought of as little more than decorative edging and an enclosed overhang, fascia and soffit protects the roof structure by forming a barrier between the edges of the roof and the elements, and helps with attic ventilation. Fascia is a vertical trim that takes the damage that Mother Nature intended for your trusses. Soffit runs horizontally from the fascia to the exterior wall of the house and is a very attractive place for insects and small animals. Deterioration on the fascia is easy to see. Deterioration on the soffit is usually spotted by damage done by these intruders. Damage to either one can cause problems with your gutters. Fascia is available in wood or PVC and costs around $10 to $30 per 8 foot board. Soffit panels cost around $20 for a 12 foot board.</p>
        <h3>Repairing Roof Trusses</h3>
        <p>These are the main structures that support your roof. Leaks often run along the trusses before dripping down onto your ceiling. As a result, when a leak happens this is one of the big things to inspect for damage. A cracked truss board can often be reinforced with steel plates or by \"sistering\" a board to either side, making sure the crack is in the middle. Attach them with construction wood screws as hammering nails in can cause even more damage with the pounding. If your truss is sagging or moldy or if you have any doubts, call a roofer for an inspection. Some molds are dangerous, if not lethal, to inhale. The cost for this is hard to estimate as the kind of damage and the repair needed can vary quite a bit. If your roof truss is so badly damaged that it can't be repaired, the cost to have the job done right can run into the thousands of dollars, so be sure to check them out thoroughly!</p>
        <h3>Roof Gutter Repairs</h3>
        <p>Cleaning your gutters isn't the most glamorous of jobs around the house; it's very time-consuming and messy. However, this job is one of the simplest things you can do to keep your roof protected, otherwise:</p>
        <ul>
            <li>They can trap water and deteriorate the fascia, the trusses, the underlayment, and can start to fall apart themselves.</li>
            <li>They leak or fall away from the house and allow all that water to pool up around your foundation. That's one repair that will cost a lot more than time and dignity!</li>
        </ul>
        <p>You may need to replace gutters that are broken or sagging so that runoff can safely leave your roof. Small holes can be patched with a tube of roofing cement and a patch. The patch material must be the same material as the gutter to prevent corrosion that can occur between different metals. This costs $2 to $4.</p>
        <ul>
            <li>Replacing a section of gutter can cost between $4 and $7 for a 10 foot section.</li>
            <li>Hangers are $1 to $2 each.</li>
            <li>If you have to replace the joiner, those are around $4.50 each.</li>
        </ul>

        ";
    }

    public function number_8(){
        return "
        <h1>Conclusion</h1>
        <p>It should go without saying that large or complicated jobs should be handled by roofing professionals. If you have any doubts about the job or if the prospect of falling off of your roof is a concern, call several contractors and collect quotes. Most common small roof repairs should cost between $150 and $400 with labor being around $45 to $75 an hour. Compared to the cost of a new roof, this is more than reasonable.</p>
        ";
    }

}
?>