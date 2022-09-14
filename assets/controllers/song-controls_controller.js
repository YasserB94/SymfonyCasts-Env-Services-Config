import { Controller } from "@hotwired/stimulus";

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
import axios from "axios";

export default class extends Controller {
  static values = {
    infoUrl: String,
  };

  async play(event) {
    event.preventDefault();
    console.log(this.element)
    event.target.classList.toggle("fa-play");
    event.target.classList.toggle("fa-pause");
    if (this.element.audio) {
      this.element.audio.pause()
      this.element.audio = null;
      return
    }


    try {
      const res = await axios.get(this.infoUrlValue);
      if (!res) throw new Error("No response!");

      this.element.audio = new Audio(res.data.url);
      this.element.audio.play();
    } catch (err) {
      console.warn("Error @ song-controls_controller.js");
      console.error(err);
    }
  }
}
